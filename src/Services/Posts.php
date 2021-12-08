<?php

declare(strict_types=1);

namespace App\Services;
use App\Request\Http\CurlHandler;
use Predis\Client as Redis;

class Posts
{
    private $redis;
    private $curlHandler;
    public function __construct()
    {
        $this->redis = new Redis();
        $this->curlHandler = new CurlHandler();
    }
    /**
     * get post data
     *
     * @return string
     */
    public function getPost()
    {
        if(empty($this->redis->exists('posts'))){
            echo 'get data from api <br />';
            $apiUrl = 'https://jsonplaceholder.typicode.com/posts';
            $fetchData = $this->curlHandler->getRequest($apiUrl);
            $this->redis->set('posts' , $fetchData);
        }else{
            echo 'get data from redis cache <br />';
        }
        return $this->redis->get('posts');
    }
    /**
     * add post data
     *
     * @return void
     */
    public function addPost(){
        $postData = $this->redis->exists('posts') ? json_decode($this->redis->get('posts'), true) : [];
        $digits = 4;
        $rand = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $postData[] = ['userId' => 15, 'id' => time().$rand, 'title' => 'New user data', 'body' => 'This is test user data'];
        $this->redis->set('posts' , json_encode($postData));
    }
    /**
     * delete post
     *
     * @return void
     */
    public function deletePost()
    {
        return $this->redis->del('posts');
    }
}
