<html>
    <head>
        <title>Cielo - Exemplos</title>
    </head>
    <body>
        <ul>
            <?php foreach(new DirectoryIterator(__DIR__) as $file): ?>
            <li><a href="<?php echo $file->getFilename(); ?>"><?php echo $file->getBasename(); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>