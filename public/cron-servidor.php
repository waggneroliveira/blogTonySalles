<?php
// cron-servidor.php - VERSÃO DEFINITIVA COM CAMINHO CORRETO
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Habilita buffer para ver tudo
ob_start();

echo "🚀 CRON SERVIDOR - EXPRESSO VIDA NOVA<br>\n";
echo "=====================================<br>\n";
echo "⏰ Início: " . date('Y-m-d H:i:s') . "<br>\n";
echo "📁 Este arquivo: " . __FILE__ . "<br>\n";
flush();

// CAMINHO ABSOLUTO CORRETO (confirmado pelo teste)
$laravelRoot = '/home/expressovidanova/expressoVidaNova_git';
$autoloadPath = $laravelRoot . '/vendor/autoload.php';

echo "🔍 Laravel Root: " . $laravelRoot . "<br>\n";
echo "🔍 Autoload Path: " . $autoloadPath . "<br>\n";

// Verifica se existe
if (!file_exists($autoloadPath)) {
    die("❌ ERRO: Autoload não encontrado em " . $autoloadPath . "<br>\n");
}

echo "✅ Autoload encontrado!<br>\n";

// Muda para o diretório do Laravel (IMPORTANTE!)
if (!chdir($laravelRoot)) {
    die("❌ ERRO: Não consegui mudar para o diretório " . $laravelRoot . "<br>\n");
}

echo "📁 Diretório atual: " . getcwd() . "<br>\n";
echo "🔍 Verificando artisan: " . (file_exists('artisan') ? '✅ EXISTE' : '❌ FALTA') . "<br>\n";
flush();

// CARREGA O LARAVEL
require $autoloadPath;

try {
    echo "🔄 Inicializando Laravel...<br>\n";
    
    $app = require_once $laravelRoot . '/bootstrap/app.php';
    echo "✅ Bootstrap carregado<br>\n";
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "✅ Kernel inicializado<br>\n";
    
    // Testa conexão com banco
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        echo "✅ Banco de dados conectado<br>\n";
    } catch (Exception $e) {
        echo "⚠️ Aviso BD: " . $e->getMessage() . "<br>\n";
    }
    
    echo "<hr><h2>🎯 EXECUTANDO COMANDOS RSS</h2>";
    flush();
    
    // Lista de comandos
    $commands = [
        'rss:g1bahia',
        'rss:govba',
    ];
    
    $sucessos = 0;
    $total = count($commands);
    
    foreach ($commands as $index => $cmd) {
        $numero = $index + 1;
        echo "<br><strong>#{$numero} ▶️ " . $cmd . "</strong><br>\n";
        flush();
        
        $inicio = microtime(true);
        
        try {
            // Cria um output collector
            $output = new \Symfony\Component\Console\Output\BufferedOutput();
            
            // Executa o comando
            $exitCode = \Illuminate\Support\Facades\Artisan::call($cmd, [], $output);
            
            $tempo = round(microtime(true) - $inicio, 2);
            $saida = $output->fetch();
            
            if ($exitCode === 0) {
                echo "✅ Sucesso ({$tempo}s)<br>\n";
                $sucessos++;
                
                if (!empty(trim($saida))) {
                    echo "📄 Saída: <pre style='background:#f0f0f0;padding:5px;'>" . 
                         htmlspecialchars($saida) . "</pre><br>\n";
                }
            } else {
                echo "⚠️ Código de saída: {$exitCode} ({$tempo}s)<br>\n";
                if (!empty($saida)) {
                    echo "📄 Saída: <pre style='background:#fff0f0;padding:5px;'>" . 
                         htmlspecialchars($saida) . "</pre><br>\n";
                }
            }
            
            // Log no sistema
            \Illuminate\Support\Facades\Log::info("Cron executado: {$cmd} - Código: {$exitCode} - Tempo: {$tempo}s");
            
        } catch (Exception $e) {
            echo "❌ Erro: " . $e->getMessage() . "<br>\n";
            \Illuminate\Support\Facades\Log::error("Erro no cron {$cmd}: " . $e->getMessage());
        }
        
        echo "---<br>\n";
        flush();
        
        // Pequena pausa entre comandos
        if ($index < $total - 1) {
            sleep(1);
        }
    }
    
    echo "<hr><h2>📊 RELATÓRIO FINAL</h2>";
    echo "✅ Comandos com sucesso: {$sucessos}/{$total}<br>\n";
    echo "⏰ Tempo total: " . date('H:i:s') . "<br>\n";
    echo "🏁 Concluído em: " . date('Y-m-d H:i:s') . "<br>\n";
    
    // Verifica se algo foi adicionado
    echo "<h3>🔍 Verificação rápida:</h3>";
    try {
        $totalPosts = \Illuminate\Support\Facades\DB::table('posts')->count();
        echo "📊 Total de posts no BD: " . $totalPosts . "<br>\n";
        
        // Últimos 3 posts
        $ultimos = \Illuminate\Support\Facades\DB::table('posts')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        if ($ultimos->count() > 0) {
            echo "📝 Últimos posts:<br>\n";
            foreach ($ultimos as $post) {
                echo "• " . substr($post->title, 0, 50) . 
                     " (" . $post->created_at . ")<br>\n";
            }
        }
    } catch (Exception $e) {
        echo "📊 Verificação BD: " . $e->getMessage() . "<br>\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERRO CRÍTICO NO LARAVEL:<br>\n";
    echo "<pre style='background:#ffcccc;padding:10px;'>" . 
         htmlspecialchars($e->getMessage() . "\n\n" . $e->getTraceAsString()) . 
         "</pre><br>\n";
}

// Finaliza
echo "<hr><p>🏁 Script finalizado.</p>\n";
ob_end_flush();