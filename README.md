# twitter-api-feed-interaction
PHP Interaction code with Twitter API for feeds. 


    <?php 
		/**
		* Most but not all the arguments for class interaction
		*/
		$twitter_args = array(
			'user'						=> 'richardblondet',
			'consumer_key'				=> 'CONSUMER-KEY',
			'consumer_secret' 			=> 'CONSUMER-SECRET',
			'access_token'				=> 'ACCESS-TOKEN',
			'access_token_secret'		=> 'TOKEN-SECRET',
			'amount' 					=> 3,
			'link_class' 				=> 'twitter-feed-link',
			'twitter_feed_class'		=> '',
			'twitter_feed_id' 			=> 'twitter-feed',
			'tweets_container'			=> 'div',
			'tweets_container_class' 	=> 'tweets',
			'tweet_single_tag'			=> 'div',
			'tweet_class' 				=> 'tweet',
			'tweet_text_class'			=> 'tweet-text',
			'show_options'  			=> true,
			'twitter_feed_show_title' 	=> false,
		);

		?>

Special thanks and primary contributor:
Raylin Aquino [@raylinanthony](https://github.com/raylinanthony)