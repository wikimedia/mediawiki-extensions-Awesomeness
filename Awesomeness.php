<?php
/**
 * Initialization file for the Awesomeness extension.
 *
 * Documentation:	 		http://www.mediawiki.org/wiki/Extension:Awesomeness
 * Support					http://www.mediawiki.org/wiki/Extension_talk:Awesomeness
 * Source code:             http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Awesomeness
 *
 * @file Awesomeness.php
 * @ingroup Awesomeness
 *
 * @licence GNU GPL v2+
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Awesomeness.
 *
 * @defgroup Awesomeness Awesomeness
 */

define( 'Awesomeness_VERSION', 'awesomeness = infinity+2' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Awesomeness',
	'version' => Awesomeness_VERSION,
	'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Awesomeness',
	'descriptionmsg' => 'awesomeness-desc',
);

$wgMessagesDirs['Awesomeness'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['Awesomeness'] = dirname( __FILE__ ) . '/Awesomeness.i18n.php';

$wgHooks['PageContentSave'][] = function ( &$wikiPage, &$user, &$content, &$summary,
	$isMinor, $isWatch, $section, &$flags, &$status ) {
	$awesomeness = array( 'awesomeness', 'awesome' );

	$awesomeness = array_map(
		function( $awesomeness ) {
			return wfMessage( $awesomeness )->text();
		},
		$awesomeness
	);

	$awesomeness = implode( "|", array_map( "preg_quote", $awesomeness, array_fill( 0, count( $awesomeness ), "/" ) ) );
	$text = preg_replace( "/(^|\s|-)((?:{$awesomeness})[\?!\.\,]?)(\s|$)/i", " '''$2''' ", ContentHandler::getContentText( $content ) );
	$content = ContentHandler::makeContent( $text, $wikiPage->getTitle() );

	return true;
};

/**
 * Based on Svips patch at http://bug-attachment.wikimedia.org/attachment.cgi?id=7351
 */
if ( array_key_exists( 'QUERY_STRING', $_SERVER ) ) {
	$O_o = false;

	if ( strtolower( $_SERVER['QUERY_STRING'] ) == 'isthiswikiawesome' ) {
		$O_o = 'Hell yeah!';
	} elseif ( preg_match( '/^[0o°xt][-_\.][0o°xt]$/i', $_SERVER['QUERY_STRING'] ) ) {
		$O_o = strrev( $_SERVER['QUERY_STRING'] );
	}

	if ( $O_o ) {
		header( 'Content-Type: text/plain' );
		die( $O_o );
	}
}
