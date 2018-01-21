<?php
$txt = $_POST['tekst'];
$txt = iconv(mb_detect_encoding($txt, mb_detect_order(), true), "UTF-8", $txt);

if ( isset($_POST['n']) && intval($_POST['n']) > 0) $n = intval($_POST['n']);
else $n = 2;

$ngrams = getNgrams($txt, $n);

echo $twig->render('result.twig',
    array('text' => $txt,
        'n' => $n,
        'ngrams' => $ngrams
    )
);


function getNgrams($txt, $n) {
    $cmd = dirname(__FILE__).'/unix/ngramprepare.sh '.$n;
    $ngrams = pipe($cmd, $txt);
    return explode(PHP_EOL, $ngrams);
}

function pipe($cmd, $stdin){

    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "a") // stderr is a file to write to
    );

    $cwd = '/tmp';
    $env = array();

    $process = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env);

    if (is_resource($process)) {
        // $pipes 0 => writeable handle connected to child stdin
        // 1 => readable handle connected to child stdout
        // Any error output will be appended to /tmp/error-output.txt

        fwrite($pipes[0], $stdin);
        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        echo stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        proc_close($process);

    }
    else $stdout = null;
    return $stdout;
}

  