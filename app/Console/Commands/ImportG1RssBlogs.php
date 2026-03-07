<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportG1RssBlogs extends Command
{
    protected $signature = 'rss:g1bahia';//php artisan rss:g1bahia
    protected $description = 'Importa notícias do RSS do G1 (categoria pelo channel)';

    public function handle()
    {
        $feeds = [
            'https://g1.globo.com/rss/g1/economia/',
            'https://g1.globo.com/rss/g1/educacao/',
            'https://g1.globo.com/rss/g1/tecnologia/',
            'https://g1.globo.com/rss/g1/mundo/',
        ];

        foreach ($feeds as $url) {
            $this->info("🔄 Processando feed: {$url}");

            try {
                $xml = $this->loadRss($url);

                /** 🔹 Categoria pelo channel */
                if (!isset($xml->channel->title)) {
                    throw new \Exception('Channel sem título');
                }

                $rawTitle = (string) $xml->channel->title; // g1 > Educação
                $categoryTitle = trim(
                    preg_replace('/^g1\s*>\s*/i', '', $rawTitle)
                );

                if (!$categoryTitle) {
                    throw new \Exception('Categoria vazia após limpeza');
                }

                $category = BlogCategory::firstOrCreate(
                    ['slug' => Str::slug($categoryTitle)],
                    [
                        'title'   => $categoryTitle,
                        'active'  => 1,
                        'sorting' => 0,
                    ]
                );

                $this->info("📂 Categoria identificada: {$categoryTitle}");

                /** 🔹 Loop dos itens */
                foreach ($xml->channel->item as $item) {

                    /** 🔹 Data (campo DATE) */
                    $pubDate = now()->toDateString();
                    if (!empty($item->pubDate)) {
                        try {
                            $pubDate = Carbon::createFromFormat(
                                'D, d M Y H:i:s O',
                                trim((string) $item->pubDate)
                            )->toDateString();
                        } catch (\Exception $e) {
                            $pubDate = Carbon::parse((string) $item->pubDate)->toDateString();
                        }
                    }

                    /** 🔹 Descrição limpa */
                    $description = '';
                    if (isset($item->description)) {
                        $description = strip_tags(
                            str_replace(
                                ['<![CDATA[', ']]>'],
                                '',
                                (string) $item->description
                            )
                        );
                    }

                    /** 🔹 Imagem (media:content ou enclosure) */
                    $imageUrl = null;
                    $namespaces = $item->getNamespaces(true);

                    if (isset($namespaces['media'])) {
                        $media = $item->children($namespaces['media']);
                        if (isset($media->content)) {
                            $attrs = $media->content->attributes();
                            $imageUrl = (string) ($attrs['url'] ?? null);
                        }
                    }

                    if (!$imageUrl && isset($item->enclosure)) {
                        $attrs = $item->enclosure->attributes();
                        $imageUrl = (string) ($attrs['url'] ?? null);
                    }

                    /** 🔹 Cria ou atualiza o post */
                    Blog::updateOrCreate(
                        ['external_link' => (string) $item->link],
                        [
                            'blog_category_id'     => $category->id,
                            'title'                => (string) $item->title,
                            'slug'                 => Str::slug((string) $item->title) . '-' . substr(md5((string) $item->link), 0, 6),
                            'date'                 => $pubDate,
                            'text'                 => $description,
                            'path_image'           => $imageUrl,
                            'path_image_thumbnail' => $imageUrl,
                            'is_rss'               => true,
                            'source'               => 'G1',
                            'active'               => 1,
                            'sorting'              => 0,
                        ]
                    );
                }

            } catch (\Throwable $e) {
                Log::error('Erro RSS G1', [
                    'url'   => $url,
                    'error' => $e->getMessage(),
                ]);

                $this->error("❌ {$e->getMessage()}");
                continue;
            }
        }

        $this->info('✅ Importação do RSS do G1 finalizada com sucesso.');
        return Command::SUCCESS;
    }

    /** 🔹 Loader robusto para RSS do G1 (gzip + redirects) */
    private function loadRss(string $url): \SimpleXMLElement
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_SSL_VERIFYPEER => false,

            // 🔥 ESSENCIAL PARA O G1
            CURLOPT_ENCODING       => '',

            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36',

            CURLOPT_HTTPHEADER     => [
                'Accept: application/rss+xml, application/xml;q=0.9,*/*;q=0.8',
            ],
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception("HTTP {$httpCode} ao acessar o feed");
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response);

        if (!$xml) {
            throw new \Exception('Resposta não é XML válido');
        }

        return $xml;
    }
}
