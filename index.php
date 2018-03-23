 <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Compare Two Jsons</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional Bootstrap theme -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    </head>
    <body>
        <?php

            $oldString = '{
    "title": "A cool blog post",
    "clicks": 4000,
    "children": null,
    "published": true,
    "comments": [
        {
            "author": "Mister X",
            "message": "A really cool posting"
        },
        {
            "author": "Misrer Y",
            "message": "It\'s me again!"
        }
    ]
}';

            $newstring = '{
    "title": "A cool blog post",
    "clicks": 4000,
    "children": null,
    "published": true,
    "comments": [
        {
            "writer": "Mister XY",
            "message": "A really cool posting"
        },
        {
            "writer": "Misrer YZ",
            "message": "It\'s me again!"
        }
    ]
}';

            $oldArray = json_decode($oldString, true);
            $newArray = json_decode($newstring, true);

            function arrayDiff( $oldArray, $newArray ) {
                $result = [];
                $keys1 = array_keys( $oldArray );
                $keys2 = array_keys( $newArray );
                foreach( $keys1 as $key ) {
                    if( isset( $newArray[ $key ] ) ) {
                        $val1 = $oldArray[ $key ];
                        $val2 = $newArray[ $key ];
                        if( is_array( $val1 ) || is_array( $val2 ) ) {
                            if( is_array( $val1 ) && is_array( $val2 ) ) {
                                $result[ $key ] = arrayDiff( $val1, $val2 );
                            } else {
                                $result[ $key ] = '<span class="text-danger">Type mismatch in both</span>';
                            }
                        } else if( $val1 == $val2 ) {
                            $result[ $key ] = '<span class="text-success">Matches</span>';
                        } else {
                            $result[ $key ] = '<span class="text-danger">' . "'$val1' in old, '$val2' in new</span>";
                        }
                        $keys2 = array_diff( $keys2, array( $key ) );
                    } else {
                        $result[ $key ] = '<span class="text-danger">not found in new array</span>';
                    }
                }
                foreach( $keys2 as $key ) {
                    $result[ $key ] = '<span class="text-warning">new item in new array</span>';
                }
                return $result;
            }

            ?>
            <div class="row">
                <div class="col-md-4"><pre><?php print_r($oldArray) ?></pre></div>
                <div class="col-md-4"><pre><?php print_r($newArray) ?></pre></div>
                <div class="col-md-4"><pre><?php print_r(arrayDiff($oldArray,$newArray)) ?></pre></div>
            </div>            

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </body>

    </html>

