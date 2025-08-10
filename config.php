<?php
session_start();

// Configuração do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'adm123Info');
define('DB_NAME', 'almoxarifado');

// Configuração do Active Directory
define('LDAP_HOST', '192.168.3.9');
define('LDAP_DOMAIN', 'DC=sme,DC=com');
define('LDAP_BASE_DN', 'DC=sme,DC=com');

// Conexão com o banco
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão com o banco: " . $e->getMessage());
}

// Função de autenticação AD
function autenticarAD($username, $password) {
    $ldapconn = ldap_connect(LDAP_HOST);
    if ($ldapconn) {
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        
        $bind = @ldap_bind($ldapconn, $username . '@sme.com', $password);
        if ($bind) {
            $filter = "(sAMAccountName=$username)";
            $result = ldap_search($ldapconn, LDAP_BASE_DN, $filter);
            $info = ldap_get_entries($ldapconn, $result);
            
            if ($info['count'] > 0) {
                ldap_close($ldapconn);
                return $info[0]['displayname'][0] ?? $username;
            }
        }
        ldap_close($ldapconn);
    }
    return false;
}

// Verifica login
function verificaLogin() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit;
    }
}
?>