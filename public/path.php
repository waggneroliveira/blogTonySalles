<?php
// path.php
echo "<h3>Informações do Servidor</h3>";
echo "Caminho absoluto atual: <strong>" . __DIR__ . "</strong><br>";
echo "Document Root: <strong>" . $_SERVER['DOCUMENT_ROOT'] . "</strong><br>";
echo "Script atual: <strong>" . $_SERVER['SCRIPT_FILENAME'] . "</strong><br>";
echo "Usuário: <strong>" . get_current_user() . "</strong><br>";
echo "Home do usuário: <strong>" . getenv('HOME') . "</strong><br>";

// Lista arquivos no diretório
echo "<h3>Arquivos no diretório:</h3>";
$files = scandir(__DIR__);
echo "<pre>";
foreach ($files as $file) {
    echo $file . "\n";
}
echo "</pre>";


// descobrir-caminhos.php - Coloque na MESMA pasta onde está o cron-servidor.php
echo "<h2>🔍 DESCOBRINDO CAMINHOS REAIS</h2>";

echo "1. Diretório deste arquivo: <strong>" . __DIR__ . "</strong><br>";
echo "2. Document Root: <strong>" . $_SERVER['DOCUMENT_ROOT'] . "</strong><br>";

// Testa vários caminhos possíveis
$testPaths = [
    __DIR__ . '/vendor/autoload.php',                    // Mesmo diretório
    dirname(__DIR__) . '/vendor/autoload.php',           // Um nível acima
    dirname(dirname(__DIR__)) . '/vendor/autoload.php',  // Dois níveis acima
    '/home/tonysalles/blogTonySalles_git/vendor/autoload.php',
    $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php',
    dirname($_SERVER['DOCUMENT_ROOT']) . '/vendor/autoload.php',
];

echo "<h3>Testando caminhos:</h3>";
foreach ($testPaths as $path) {
    $exists = file_exists($path) ? '✅ EXISTE' : '❌ NÃO EXISTE';
    echo $exists . ": " . $path . "<br>";
}

// Verifica se o artisan existe
echo "<h3>Procurando artisan:</h3>";
$artisanPaths = [
    __DIR__ . '/../artisan',
    dirname(__DIR__) . '/artisan',
    '/home/tonysalles/blogTonySalles_git/artisan',
    $_SERVER['DOCUMENT_ROOT'] . '/../artisan',
];

foreach ($artisanPaths as $path) {
    $exists = file_exists($path) ? '✅ EXISTE' : '❌ NÃO EXISTE';
    echo $exists . ": " . $path . "<br>";
}