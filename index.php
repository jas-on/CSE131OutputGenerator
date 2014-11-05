<?php
include 'dirs.php';

function execOutput($command, $filename) {
    $output = array();
    exec($command.' 2>&1', $output);

    $pattern = '/' . preg_quote($filename, '/') . '/i';
    return preg_replace($pattern, '', implode("\n", $output));
}

if (isset($_POST["test"])) {
    $input = $_POST["test"];

    $temp = tempnam($UPLOAD_FOLDER, "foo");
    file_put_contents($temp, $input);
    $cmd = "java -cp " . $JAVA_CODE_DIR . "java-cup-v11a.jar:" . $JAVA_CODE_DIR . " RCdbg " . $temp;
    $output = execOutput($cmd, $temp);
}

if (isset($_GET['raw'])) {
    echo $output; die();
}
?>
<html>
    <head>
        <style>
            .input {
                border: 2px dashed orange;
            }
            .output {
                border: 2px dashed green;
            }
            textarea {
                width: 100%;
                overflow-y: auto;
                height: 100%;
            }
            .submit {
                width: 100%;
                font-size: 30px;
            }
            .column-left {
                 float: left; width: 33%;
            }
            .column-right {
                float: right; width: 33%;
            }
            .column-center {
                display: inline-block; width: 33%;
            }
        </style>
    </head>
    <body>
        <div class="column-left">
            <h1>New Submission</h1>
            <form action="" method="post">
                <input class="submit" type="submit">
                <br/>
                <textarea placeholder="Enter test here" name="test"></textarea>
            </form>
        </div>
        <div class="column-center">
            <h1>Input</h1>
            <textarea readonly class="input"><?= $input ?></textarea>
        </div>
        <div class="column-right">
            <h1>Output</h1>
            <textarea readonly class="output"><?= $output ?></textarea>
        </div>
    </body>
</html>
