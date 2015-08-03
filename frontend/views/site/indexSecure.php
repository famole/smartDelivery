<?php
use kartik\tabs\TabsX;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
$this->title = 'Smart Delivery';
?>

<html lang="en">
    <head>
        <link rel="stylesheet" href="css/demo.css">
        <link rel="stylesheet" href="dist/ladda.min.css">
    </head>
    <body>
        <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-out" name="submit">
            <span class="ladda-label">Submit</span>
            <span class="ladda-spinner"></span>
        </button>
        
        <button class="btn btn-primary ladda-button" data-style="expand-left"><span class="ladda-label">expand-left</span></button>
        <script src="dist/spin.min.js"></script>
        <script src="dist/ladda.min.js"></script>
        <script>
            Ladda.bind( '.ladda-button', { timeout: 2000 } );
        </script>
    </body>
</html>
