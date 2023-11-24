<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'avelino08092021' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'avelino' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'T01&d0_2021' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );





/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pl=A%|#4K;F`TE8(k&L0d3kkWu_6~Y [NX|qt3cWy-<}dw`E,1whv9eGk`uU|Hh<' );
define( 'SECURE_AUTH_KEY',  'm{<ageK6t..s7[?YyZ-prab4eeUPV:<0$UIsO?87|g!o#iq9o)@I%CC`T=ZhteM#' );
define( 'LOGGED_IN_KEY',    '`cqNL7W?$u;n0a~fV?Ib*0u%$:<UseHO/Cf}n(,RfikaS>=bx:(ngXEfT~PsV@mR' );
define( 'NONCE_KEY',        'S+Xw:?cnwogHaax3e{G.lH@nF#C,>pK>1FqC?GR<;EJ<!lV{sVj)32]-yMUj0,$<' );
define( 'AUTH_SALT',        'Y+/!lR?CZf)jrQ7Rk[~#CJ=KbO:[^*%+2WpB-3US4+].pB1kz&@iU,@aI0iQsgB`' );
define( 'SECURE_AUTH_SALT', 'b]=zW(Ux*[PXBAoUKUmzYd5nLzDgI?XP6*,U U!K3oXE4VNN44Yg17h[s(X*it`!' );
define( 'LOGGED_IN_SALT',   'm|q.:1;[PBJmMi<wP&hVhVjY-<Yn1R!SWY=t{<2[Sw+ ZRAxal+RJBESXy24yv;M' );
define( 'NONCE_SALT',       '6IX(b_?dU)}:R=%#*2Lh`LTAsu-mY-})[z|7CRGYf0hFOzXbO$CjA@j6j*/}c6y)' );

@ini_set( 'upload_max_filesize' , '1024M' );
@ini_set( 'post_max_size', '1024M');
@ini_set( 'memory_limit', '2048M' );
@ini_set( 'max_execution_time', '600' );
@ini_set( 'max_input_time', '600' );
/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'toledo';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
