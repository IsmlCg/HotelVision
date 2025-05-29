<?php
interface MessageContent
{
	public function to_array() : array;
}

final class TextContent implements MessageContent
{
    public function __construct(
		private string $content
	) {}

	public function to_array() : array
	{
		return [ 'type' => 'text', 'text' => $this->content ];
	}
}

final class ImageUrlContent implements MessageContent
{
    public function __construct(
		private string $url
	) {}

	public function to_array() : array
	{
		return [ 'type' => 'image_url', 'image_url' => [ 'url' => $this->url ] ];
	}
}

class Conversation
{
	private string $endpoint;
	private string $api_key;
	
	/** @var array<string> */
	private array  $messages;

	private function __construct() {}

	static public function new(string $endpoint, string $api_key) : self|Error
	{
		$model = new self;
		$model->endpoint = $endpoint;
		$model->api_key  = $api_key;
		$model->messages = [];
		return $model;
	}

	public function add_message(string $role, string|array|MessageContent $content) : self
	{
        if(is_array($content))
		{
			$new_content = [];
			foreach($content as $part)
			{
				if(is_string($part) || is_array($part))
					$new_content[] = $part;
				else
					$new_content[] = $part->to_array();
			}
			$content = $new_content;
		}

		$this->messages[] = [
			'role'    => $role,
			'content' => $content,
		];
		return $this;
	}

	public function prompt(array|string|MessageContent $content) : string
	{
		$headers = [
			'content-type: application/json',
			'authorization: Bearer '.$this->api_key,
		];

		$this->add_message('user', $content);

		$args = [
			'messages' => $this->messages,
			'max_tokens'  => 4096,
			'temperature' => 1,
			'top_p'       => 1,
			'model'       => 'gpt-4o',
		];

		$ch = curl_init($this->endpoint);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response    = json_decode(curl_exec($ch), true);
		$res_content = $response['choices'][0]['message']['content'] ?? 'No description generated.';
		curl_close($ch);

		$this->add_message('assistant', $res_content);

		return $res_content;
	}
}


