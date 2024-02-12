<?php

namespace KN\BookPlugin;
/**
 * Represents a Contact Shortcode
 */
class ContactShortcode extends Singleton
{

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Contact Shortcode constructor
     */
    protected function __construct()
    {
        add_shortcode('kn-social-media-block', [$this, 'socialMediaShortcode']);
    }

    /**
     * @return void Prevent cloning (PHP specific)
     */
    protected function __clone(){}

    /**
     * @param $attributes
     * @return string Display a list of formatted social media links
     */
    public function socialMediaShortcode($attributes){
        // display a list of social media
        $a = shortcode_atts([
            'facebook_url' => 'https://www.facebook.com/JohnGreenfans',
            'twitter_url' => 'https://twitter.com/johngreen',
            'email' => 'johngreenwritesbooks@gmail.com',
        ], $attributes);

        return "<div class='social-media'>
                    {$this->facebookIcon($a['facebook_url'])}
                    {$this->twitterIcon($a['twitter_url'])}
                    {$this->mailIcon($a['email'])}
                </div>";
    }

    /**
     * @param $url
     * @return bool Return if the website is blank
     */
    public function isBlankUrl($url){
        return $url == '';
    }

    /**
     * @param $url
     * @return bool Return if the website is a Facebook link
     */
    public function isFacebookLink($url){
        return str_contains($url, 'facebook.com');
    }

    /**
     * @param $url
     * @return bool Return if the website is a Twitter link
     */
    public function isTwitterLink($url){
        return str_contains($url, 'twitter.com');
    }

    /**
     * @param mixed|string $attribute Link to a Facebook account
     * @return string Return formatted Facebook link
     */
    public function facebookIcon($attribute){
        if(!$this->isBlankUrl($attribute) && $this->isFacebookLink($attribute)){
            return "<a href='{$attribute}' target='_blank'>
                        <span class='social-icon'>
                            <i class='fa fa-facebook' aria-hidden='true'></i>
                       </span>
                    </a>";
        }
        else return '';
    }

    /**
     * @param mixed|string $attribute Link to a Twitter account
     * @return string Return formatted Twitter link
     */
    public function twitterIcon($attribute){
        if(!$this->isBlankUrl($attribute) && $this->isTwitterLink($attribute)){
            return "<a href='{$attribute}' target='_blank'>
                        <span class='social-icon'>
                            <i class='fa fa-twitter' aria-hidden='true'></i>
                       </span>
                    </a>";
        }
        else return '';
    }

    /**
     * @param mixed|string $attribute Link to an email account
     * @return string Return formatted email link
     */
    public function mailIcon($attribute){
        if(!$this->isBlankUrl($attribute)){
            return "<a href='{$attribute}' target='_blank'>
                        <span class='social-icon'>
                            <i class='fa fa-envelope-o' aria-hidden='true'></i>
                       </span>
                    </a>";
        }
        else return '';
    }
}