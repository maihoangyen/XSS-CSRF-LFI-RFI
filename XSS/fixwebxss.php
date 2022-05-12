<!DOCTYPE html>

<html lang="en-GB">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
    <div >
    <h1>Welcom to myweb</h1>

    <div >
        <form action="#" method="GET">
            <p>
                Mời nhập ID:
                <input type="text" size="15" name="id">
                <input type="submit" name="Submit" value="Submit">
            </p>

        </form>
        
    </div>
    </body>

</html>
<?php

if( array_key_exists( "id", $_GET ) && $_GET[ 'id' ] != NULL ) {
    $id = str_replace( '<script>', '', $_GET[ 'id' ] );
    echo "Hello ${id}";
}

?>