<?php  
/**
* Plugin de Twitter
*
* @since 0.2
*
* @package cluster-soft
* @subpackage social-plugin
*/


/* Verificamos que esta clase no exista */
if(! class_exists( 'twitter' )) {

	/**
	* Twitter class.
	*
	* Esta clase nos permitirá manejar el plugin de twitter
	* sin ser tan intrusivos en el template;
	*
	* @category social-plugin
	* 
	* @author Richard Blondet <richard@adventures.do> @richardblondet
	* @since 0.2.1
	*
	* @author Raylin Aquino <raylin@adventures.do>
	* @since 0.01 2014-11-13
	*
	* @see TwitterFeed es la clase de la que depende
	* @link vendor/Twitter/twitter.class.php
	*
	*/
	class twitter {
		/**
		* Twitter.
		*
		* @since 0.2.1
		* @access protected
		* @var Object $twitter El objeto de twitter
		*/
		protected $twitter;

		/**
		* Twitter connection.
		*
		* @since 0.2.1
		* @access protected
		* @var String $access_token El token de acceso
		*/
		protected $connection;

		/**
		* Config.
		*
		* @since 0.2.2
		* @access protected
		* @var Array $config Las configuraciones del básicas del plugin
		*/
		protected $config = array(
			'user'						=> '',
			'amount' 					=> 3,
			'json'						=> false, // Return PHP JSON Object
			'link_class' 				=> 'twitter-link',
			'dates_timezone'			=> 'America/Santo_Domingo',
			'twitter_feed_id' 			=> 'twitter',
			'twitter_feed_class'		=> 'panel panel-default',
			'twitter_feed_show_title'	=> true,
			'twitter_feed_title'		=> 'Twitter',
			'twitter_title_class'		=> 'panel-heading',
			'twitter_feed_follow_btn'	=> true,
			'twitter_feed_follow_label'	=> 'seguir',
			'tweets_container'			=> 'ul',
			'tweets_container_class' 	=> 'list-group tweets',
			'tweet_single_tag'			=> 'li',
			'tweet_class' 				=> 'tweet',
			'tweet_text_class'			=> 'tweet-text',
			'show_options'  			=> true,
			'tweet_options_class'		=> 'tweet-btn'
		);


		/**
		* Construct nuestra clase.
		*
		* @since 0.2.1
		* @access public
		* @param $args;
		* 	@param $user
		* 	@param $consumer_key;
		* 	@param $consumer_secret;
		* 	@param $access_token;
		* 	@param $access_token_secret;
		*   @param $amount; Integer
		* 	@param $json; Boolean
		* 	@param $links_class; String
		* 	@param $dates_timezone;
		* 	@param $twitter_feed_id;
		* 	@param $twitter_feed_class;
		*	@param $twitter_feed_show_title;
		* 	@param $twitter_feed_title;
		* 	@param $twitter_title_class; 
		*	@param $twitter_feed_follow_btn;
		* 	@param $twitter_feed_follow_label;
		* 	@param $tweets_container;
		* 	@param $tweets_container_class;
		* 	@param $tweets_container_class;
		* 	@param $tweet_single_tag;
		* 	@param $tweet_class;
		* 	@param $tweet_text_class;
		* 	@param $show_options;
		* 	@param $tweet_options_class;
		*/
		public function __construct ( $args = array() ) {
			
			/* Verificar Valores Requeridos */
			if(! isset($args['user'])) {
				throw new WP_Error( 'twitter_user', __( "Debe proveer un usuario de twitter", "theme-911" ));
			}
			if(! isset($args['consumer_key'])) {
				throw new WP_Error( 'twitter_config_consumer_key', __( "Debe proveer un consumer key.", "theme-911" ));
			}
			if(! isset($args['consumer_secret'])){
				throw new WP_Error( 'twitter_config_consumer_secret', __( "Debe proveer un consumer secret.", "theme-911" ));
			}
			if(! isset($args['access_token'])){
				throw new WP_Error( 'twitter_config_access_token', __( "Debe proveer un token de acceso.", "theme-911" ));
			}
			if(! isset($args['access_token_secret'])){
				throw new WP_Error( 'twitter_config_access_token_secret', __( "Debe proveer un token de acceso secret.", "theme-911" ));
			}
			if( isset($args['amount'])) {
				$this->config['amount'] = $args['amount'];
			}
			if( isset($args['json']) && is_bool($args['json']) ) {
				$this->config['json'] = $args['json'];
			}
			if( isset($args['links_class'])) {
				$this->config['link_class'] = $args['links_class'];
			}
			if( isset($args['dates_timezone']) ) {
				$this->config['dates_timezone'] = $args['dates_timezone'];
			}
			if( isset($args['twitter_feed_id']) ) {
				$this->config['twitter_feed_id'] = $args['twitter_feed_id'];
			}
			if( isset($args['twitter_feed_class']) ) {
				$this->config['twitter_feed_class'] = $args['twitter_feed_class'];
			}
			if( isset($args['twitter_feed_show_title']) ) {
				$this->config['twitter_feed_show_title'] = $args['twitter_feed_show_title'];
			}
			if( isset($args['twitter_feed_title']) ) {
				$this->config['twitter_feed_title'] = $args['twitter_feed_title'];
			}
			if( isset($args['twitter_title_class']) ) {
				$this->config['twitter_title_class'] = $args['twitter_title_class'];
			}
			if( isset($args['twitter_feed_follow_btn']) ) {
				$this->config['twitter_feed_follow_btn'] = $args['twitter_feed_follow_btn'];
			}
			if( isset($args['twitter_feed_follow_label']) ) {
				$this->config['twitter_feed_follow_label'] = $args['twitter_feed_follow_label'];
			}
			if( isset($args['tweets_container']) ) {
				$this->config['tweets_container'] = $args['tweets_container'];
			}
			if( isset($args['tweets_container_class']) ) {
				$this->config['tweets_container_class'] = $args['tweets_container_class'];
			}
			if( isset($args['tweets_container_class']) ) {
				$this->config['tweets_container_class'] = $args['tweets_container_class'];
			}
			if( isset($args['tweet_single_tag']) ) {
				$this->config['tweet_single_tag'] = $args['tweet_single_tag'];
			}
			if( isset($args['tweet_class']) ) {
				$this->config['tweet_class'] = $args['tweet_class'];
			}
			if( isset($args['tweet_text_class']) ) {
				$this->config['tweet_text_class'] = $args['tweet_text_class'];
			}
			if( isset($args['show_options'])) {
				$this->config['show_options'] = $args['show_options'];
			}
			if( isset($args['tweet_options_class'])) {
				$this->config['tweet_options_class'] = $args['tweet_options_class'];
			}

			/* Twitter user */
			$this->config['user'] = $args['user'];

			/* Pasar las configuraciones básicas de conexión */
			$this->connection  = new TwitterOAuth(
				$args['consumer_key'], 
				$args['consumer_secret'], 
				$args['access_token'], 
				$args['access_token_secret']
			);

			/* Si el usuario quiere los tweets en un objeto retornarlos */
			if( true === $this->config['json'] ) {
				$json_obj = $this->get_tweets();
				return json_encode($json_obj);
			} else {
				/* Correr El plugin */
				$this->plugin();
			}
		}

		/**
		* El plungin.
		*
		* @since 0.2.1
		* @access public
		* 
		*/
		public function plugin() {

			/* Cargamos los tweets */
			$tweets = $this->get_tweets();

			
			/* Buffer inicialización y Plugin */
			ob_start(); ?>
			
			<?php /* Twitter Template */ ?>
			<div id="<?php 
			 			/* Twitter Feed Id */
						echo $this->config['twitter_feed_id'];
							?>" class="<?php
											/* Twitter Feed Class */
											echo $this->config['twitter_feed_class'];
				
												?>">
				<?php if( true === $this->config['twitter_feed_show_title'] ): ?>
					<div class="<?php 
									echo $this->config['twitter_title_class']; 
										?>">
						<?php 
							/* Twitter Feed Title */
							echo $this->config['twitter_feed_title']; 
								?>
						<?php if( true === $this->config['twitter_feed_follow_btn'] ): ?>
							<a href="https://twitter.com/intent/follow?screen_name=<?php echo $this->user; ?>" target="_blank" class="btn btn-follow">
								<?php echo $this->config['twitter_feed_follow_label']; ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<!-- Tweets -->
				<?php if ( count($tweets) > 0 ): ?>
				<<?php 
					/* Tweets Container Tag */
					echo $this->config['tweets_container']; 
						?> class="<?php 
									/* Tweets Container Class */
									echo $this->config['tweets_container_class']; 
										?>">

					<?php 
					/* Recorrer los tweets */
						foreach($tweets as $tweet => $data):
				 
						$text = $this->link_it($data->text);
						$text = $this->twitter_it($text);
					?>
					<<?php 
						/* Tweet Single Element Tag */
						echo $this->config['tweet_single_tag']; 
							?> class="<?php 
										echo $this->config['tweet_class']; 
											?>">
						<div class="adv-tweet-text-container">
							<span class="<?php 
											echo $this->config['tweet_text_class'];
												?>">
								<?php echo $text; ?>
							</span>
						</div>
						<div class="adv-tweet-time-container">
							<span class="time-past"><?php 
								/* Mostramos las fechas de twitter en formato de Santo Domingo, Seleccionado */
								$date = new DateTime( $data->created_at );
								$date->setTimezone(new DateTimeZone($this->config['dates_timezone']));
								$formatted_date = $date->format('H:i, M d');
								echo $formatted_date;
							?></span>
						</div>
						<?php if( true === $this->config['show_options'] ): ?>
							<div class="adv-tweet-controls">
								<a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo strval( $data->id_str ); ?>" target="_blank" class="<?php echo $this->config['tweet_options_class']; ?>">
									<i class="fa fa-reply"></i> 
								</a>
								<a href="https://twitter.com/intent/retweet?tweet_id=<?php echo strval( $data->id_str ); ?>" target="_blank" class="<?php echo $this->config['tweet_options_class']; ?>">
									<i class="fa fa-retweet"></i> 
								</a>
								<a href="https://twitter.com/intent/favorite?tweet_id=<?php echo strval( $data->id_str ); ?>" target="_blank" class="<?php echo $this->config['tweet_options_class']; ?>">
									<i class="fa fa-star"></i> 
								</a>
								<a href="https://twitter.com/intent/user?screen_name=<?php echo $this->user; ?>" target="_blank" class="<?php echo $this->config['tweet_options_class']; ?>">
									<i class="fa fa-ellipsis-h"></i> 
								</a>
							</div>
						<?php endif; ?>
					</<?php 
						/* Tweet Single Element Tag */
						echo $this->config['tweet_single_tag']; 
							?>>
					<?php endforeach; ?>
				</<?php 
					/* Tweets Container Class */
					echo $this->config['tweets_container']; 
						?>>
				<?php endif; ?>
			</div>
			<?php
			/* El resultado de lo anterior lo mostramos */
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
		}

		/**
		* Formatear nuestros tweets
		*
		* @since 0.01
		* @access public
		* @param String $text el texto en caracteres de nuestro tweet.
		*
		* @author Raylin Aquino
		*/
		public function twitter_it($text) {   
	       
	        $to = array("á","é", "ñ","Ñ");
	        $from = array("a","e", "n","N");
	        $text = str_replace($to, $from, $text); 
	        $text = preg_replace("/@(\w+)/", '<a class="twitter-link"  href="http://www.twitter.com/$1" target="_blank">@$1</a>', $text);
	        $text = preg_replace("/\#(\w+)/", '<a class="twitter-link"  href="https://twitter.com/search?q==$1" target="_blank">#$1</a>', $text);
	        
	        return $text;
	    }

	    /**
	    * Formatear los enlaces incluidos en twitter
	    *
	    * @since 0.01
	    * @access public
	    * @param String $text el texto en caracteres de nuestro tweet.
	    * 
	    * @return String $text nueva string
		*
		* @author Raylin Aquino
	    */
	    public function link_it($text) {
	    	$text = htmlspecialchars($text, ENT_QUOTES, "UTF-8");
	        $text = preg_replace(
			        	array(
				            '/(^|\s|>)(www.[^<> \n\r]+)/iex',
				            '/(^|\s|>)([_A-Za-z0-9-]+(\\.[A-Za-z]{2,3})?\\.[A-Za-z]{2,4}\\/[^<> \n\r]+)/iex',
				            '/(?(?=<a[^>]*>.+<\/a>)(?:<a[^>]*>.+<\/a>)|([^="\']?)((?:https?):\/\/([^<> \n\r]+)))/iex'
			        	), 
			        	array(
				            "stripslashes((strlen('\\2')>0?'\\1<a href=\"http://\\2\"  class=\"twitter-link\" target=\"_blank\">\\2</a>&nbsp;\\3':'\\0'))",
				            "stripslashes((strlen('\\2')>0?'\\1<a href=\"http://\\2\" class=\"twitter-link\"  target=\"_blank\">\\2</a>&nbsp;\\4':'\\0'))",
				            "stripslashes((strlen('\\2')>0?'\\1<a href=\"\\2\" class=\"twitter-link\" target=\"_blank\">\\3</a>&nbsp;':'\\0'))"
			        	), 
	        		$text
	        	);
	        
	        return ($text);
	    }

	    /**
	    * Obtener los Tweets desde Twitter
	    * 
	    * @since 0.01
	    * @access private
	    * @return tweets objets
	    */
	    private function get_tweets() {
	        $tweets = $this->connection->get(
	        	"https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $this->config['user'] . "&count=" . $this->config['amount'] 
	        );
	        return $tweets;
	    }

	}
} 

?>