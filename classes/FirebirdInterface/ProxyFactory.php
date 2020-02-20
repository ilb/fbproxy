<?php

class FirebirdInterface_ProxyFactory {

    /**
     * @param PDO $pdo
     * @return FirebirdInterface_Proxy
     */
    public static function generateProxy(PDO $pdo) {
        return new FirebirdInterface_Proxy($pdo);
    }

}
