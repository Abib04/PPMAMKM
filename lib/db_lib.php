<?php

include "config/connection.php";

include "o_lib.php";



function db_insert($table, $data = array()){

    global $con;

    if(is_array($data)){

        if(count($data) > 0){

            if(isArrayAssoc($data)){

                if(isArrAssocString($data)){

                    $q = "insert into " . $table . " set ";

                    foreach($data as $column => $value){

                        $q .= "`" . $column . "` = '" . $value . "', ";

                    }
                    

                    //echo rtrim($q, ", ");

                     $sql = mysqli_query($con, rtrim($q, ", "));



                    if(mysqli_affected_rows($con) > 0){

                        return TRUE;

                    }else{

                        $_SESSION['err_message'] = mysqli_error($con);
                        
                        //echo $q;

                        return FALSE;

                    }

                }

            }

        }

    }

}


function db_select($query){
    return db_read($query);
}
function db_read($query){

    global $con;

    if(!is_null($query)){

        mysqli_set_charset($con, "utf8");

        $sql = mysqli_query($con, $query);

        $buffer = array();

        while($row = mysqli_fetch_assoc($sql)){

            $buffer[] = $row;

        }

        

        return $buffer;

    }

}





function db_update($table, $data = array(), $where = array()){

    global $con;

    if(is_array($data)){

        if(count($data) > 0){

            if(isArrayAssoc($data)){

                if(isArrAssocString($data)){

                    $q = "update " . $table . " set ";

                    foreach($data as $column => $value){

                        $q .= "`" . (isset($column) ? $column : 'null') . "` = " . (is_null($value) ? "null" : "'$value'") . ", ";

                    }

                    

                    $q = rtrim($q, ", ");



                    if(is_array($where)){

                        if(count($where) > 0){

                            if(isArrayAssoc($where)){

                                $q .= " where ";

                                foreach($where as $w => $value){

                                    $q .= "`" . $w . "` = '" . $value . "' AND";

                                }

                            }



                            $q = rtrim($q, "AND");

                        }

                    }

                    

                    $sql = mysqli_query($con, $q);



                    if(mysqli_affected_rows($con) > 0){

                        return TRUE;

                    }else{

                        $_SESSION['err_message'] = mysqli_error($con);

                        return FALSE;

                    }

                }

            }

        }

    }

}



function db_delete($table, $where = array()){

    global $con;

    if(is_array($where)){

        if(isArrayAssoc($where)){

            $q = "delete from " . $table;

            if(count($where) != 0){

                $q .= " where ";

                foreach($where as $w => $value){

                    $q .= "`" . $w . "` = '" . $value . "' AND";

                }

            }



            $q = rtrim($q, "AND");

            $sql = mysqli_query($con, $q);



            if(mysqli_affected_rows($con) > 0){

                return TRUE;

            }else{

                $_SESSION['err_message'] = mysqli_error($con);

                return FALSE;

            }

        }

    }

}



function db_lastID(){

    global $con;

    return mysqli_insert_id($con);

}



function db_free_query($query){

    global $con;

    // echo $query;

    mysqli_query($con, $query) or die(print_r(mysqli_error($con)));

    if(mysqli_affected_rows($con) > 0){

        return TRUE;

    }else{

        $_SESSION['err_message'] = mysqli_error($con);

        return FALSE;

    }

}

