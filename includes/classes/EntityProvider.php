<?php

class EntityProvider{

    public static function getEntities($con, $categoryId, $limit){

        $sql = "SELECT * FROM entities ";

        if($categoryId != null){
            $sql .= "WHERE categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null){
            $query->BindValue(":categoryId", $categoryId);
        }

        $query->BindValue(":limit", $limit, PDO::PARAM_INT);// binding integer values.
        $query->execute();

        $result = [];

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result [] = new Entity($con,$row);
        }

        return $result;


    }
}

?>