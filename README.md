# twitter-api-feed-interaction
PHP Interaction code with Twitter API for feeds. 


    <?php 
		/**
		* Argumentos para el feed de twitter
		*/
		$twitter_args = array(
			'user'						=> 'richardblondet',
			'consumer_key'				=> 'CONSUMER-KEY',
			'consumer_secret' 			=> 'CONSUMER-SECRET',
			'access_token'				=> 'ACCESS-TOKEN',
			'access_token_secret'		=> 'TOKEN-SECRET',
			'amount' 					=> 3,
			'link_class' 				=> 'adv-twitter-feed-link',
			'twitter_feed_class'		=> '',
			'twitter_feed_id' 			=> 'adv-twitter-feed-'.$this->textdomain,
			'tweets_container'			=> 'div',
			'tweets_container_class' 	=> 'adv-tweets',
			'tweet_single_tag'			=> 'div',
			'tweet_class' 				=> 'adv-tweet',
			'tweet_text_class'			=> 'adv-tweet-text',
			'show_options'  			=> false,
			'twitter_feed_show_title' 	=> false,
		);

		?>

Special thanks and primary contributor:
Raylin Aquino [@raylinanthony](https://github.com/raylinanthony)