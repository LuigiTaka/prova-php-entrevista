<?php

namespace TestePratico;

class Utils
{

    static public function indexBy( string $column, array $data ): array
    {
        $keys = array_column( $data,$column );
        return array_combine($keys,$data);
    }

}