<?php defined('BLUDIT') or die('Unauthorized access!');

/** -------------------------------------------------------------------------------
 *  Humans.txt plugin
 *  -------------------------------------------------------------------------------
 *  It simply adds human.txt file to your website
 *
 *  @author Lukino
 *  @link https://jen-tak.tk/
 *  @version 1.2
 *  @filesource
 */
class pluginHumanstxt extends Plugin {



    /** Init default settings
     *
     * @return void
     */
	public function init()
	{
		$this->dbFields = array(
			'humanstxt' => '/* TEAM */' . PHP_EOL . 'Web Developer: [yourname]' . PHP_EOL . 'Twitter: [yourtwitter]' . PHP_EOL . 'Github: [yourgithub]' . PHP_EOL . 'From: [yourlocation]' . PHP_EOL . PHP_EOL . '/* THANKS */' . PHP_EOL . 'Translator: ...' . PHP_EOL . 'Sponsor: ...' . PHP_EOL . 'Etc...' . PHP_EOL . PHP_EOL . '/* SITE */' . PHP_EOL . 'Last update: 2020/11/16' . PHP_EOL . 'Software: Geany, Filezilla, Firefox, etc...' . PHP_EOL,
		);
	}



    /** Create form for settings in administration
     *
     * @return void
     */
	public function form()
	{
        global $site;
        global $L;

        $html  = '';
        $html .= '<div class="card shadow mt-5">';
        $html .= '<h5 class="card-header">' . $L->get('ld-humanstxt-card-info') . '</h5>';
        $html .= '<div class="card-body">';
        $html .= '<p class="card-text">' . $this->description() . '</p>';
        $html .= '<a href="http://humanstxt.org/" class="btn btn-primary" target="_blank" rel="noopener noreferrer">' . $L->get('ld-open-humanstxt-web') . '</a>';
        $html .= '<a href="#" data-toggle="modal" data-target="#donateHumanstxtModal" title="Donate BTC" class="btn btn-success mx-3 text-center float-right" style="fill:#fff;">' . $L->get('ld-donate-link') . '<br><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path d="M13.953 13.452c0 .892-1.133 1.048-2.786 1.048v-2.086c1.562 0 2.786.081 2.786 1.038zm10.047-8.452v14c0 1.104-.896 2-2 2h-20c-1.104 0-2-.896-2-2v-14c0-1.104.896-2 2-2h20c1.104 0 2 .896 2 2zm-8.25 8.326c0-1.066-.866-1.528-1.491-1.687.515-.186 1.113-.948.872-1.857-.204-.768-.916-1.45-2.714-1.51v-1.272h-.833v1.25h-.417v-1.25h-.833v1.25h-2.084v1.25h.681c.367 0 .569.238.569.585v3.704c0 .357-.211.711-.579.711h-.45l-.208 1.241h2.07v1.259h.833v-1.259h.417v1.259h.833v-1.25c2.214 0 3.334-.972 3.334-2.424zm-2.259-2.784c0-.833-.866-1.042-2.324-1.042v2.083c.921 0 2.324-.065 2.324-1.041z"/></svg></a>';
        $html .= '</div>';
        $html .= '</div>';

		$html .= '<div class="form-group mt-5 mb-5">';
		$html .= '  <label for="humanstxt">' . $L->get('ld-file') . ' <a href="' . str_replace('//humans.txt', '/humans.txt', $site->url() . '/humans.txt' ) . '" title="" target="_blank" rel="noreferrer noopenner">' . str_replace('//humans.txt', '/humans.txt', $site->url() . '/humans.txt' ) . '</a></label>';
		$html .= '  <textarea id="humanstxt" name="humanstxt" class="form-control" aria-describedby="humanstxtHelp" style="min-height: 25em;">' . str_replace("<br />", "\n", nl2br( $this->getValue('humanstxt') ) ).'</textarea>';
		$html .= '  <small id="humanstxtHelp" class="form-text text-muted">' . $L->get('ld-humanstxt-description') . '</small>';
        $html .= '</div>';

        $html .= '<p class="clearfix mt-5 mb-5">&nbsp;</p>';
        $html .= '<div class="modal fade" id="donateHumanstxtModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">' . $L->get('ld-donate-title') . '</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p><img src="' . DOMAIN_PLUGINS . basename( __DIR__ ) . '/img/qr.png" alt="" class="mx-auto d-block img-fluid" /></p><p><br>' . $L->get('ld-donate-text') . '</p><p>BTC: <code><a href="bitcoin:39xYc2jxrxFMiWgWDw7RYUmyF7vF331QWX">39xYc2jxrxFMiWgWDw7RYUmyF7vF331QWX</a></code></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">' . $L->get('ld-close') . '</button></div></div></div></div>';

		// compress output
        return trim( str_replace('    ', '', str_replace("\t", '', str_replace("\r\n", '', $html) ) ) );
	}



    /** Create meta tag in header
     *
     * @return void
     */
	public function siteHead()
	{
        global $site;

        $html  = PHP_EOL . '<!-- Humans.txt -->' . PHP_EOL;
        $html .= '<link rel="author" href="' . str_replace('//humans.txt', '/humans.txt', $site->url() . '/humans.txt' ) . '" />'.PHP_EOL;
		return $html;
	}



    /** Create humans.txt file
     *
     * @return void
     */
	public function beforeAll()
	{
		$webhook = 'humans.txt';
		if ( $this->webhook( $webhook ) )
        {
            $humansFile = $this->workspace() . $webhook;
			$humansSize = filesize( $humansFile );
			header( 'Content-type: text/plain; charset=utf-8' );
            header( 'Content-length: ' . $humansSize );

			echo $this->getValue('humanstxt');
			exit(0);
		}
	}

}
