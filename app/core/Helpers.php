<?php 

class Helpers{
    public function insertOrUpdate(array $rows, $table){

        $first = reset($rows);
    
        $columns = implode( ',',
            array_map( function( $value ) { return "$value"; } , array_keys($first) )
        );
    
        $values = implode( ',', array_map( function( $row ) {
                return '('.implode( ',',
                    array_map( function( $value ) { return '"'.str_replace('"', '""', $value).'"'; } , $row )
                ).')';
            } , $rows )
        );
    
        $updates = implode( ',',
            array_map( function( $value ) { return "$value = VALUES($value)"; } , array_keys($first) )
        );
    
        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";
    
        return $sql;
    }
}