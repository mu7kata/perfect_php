<?php

//HTMLなどのコンテンツをレスポンスとして返す役割。管理しやすくするために一元管理する。

class Response
{
  protected $content;
  protected $status_code=200;
  protected $status_text='OK';
  protected $http_headers=array();

  //レスポンスの送信
  public function send()
  {
    header('HTTP/1.1'.$this->status_code.''.$this->status_text);

    foreach($this->http_headers as $name =>$value){
      header($name.': '. $value);
    }
    echo $this->content;
  }

  //HTMLなど実際にクライアントに返す値を格納
  public function setContent($content)
  {
    $this->content=$content;
  }

  //レスポンスの状態、404NotFoundなど、HTTPのステータスコードを格納
  public function setStatusCode($status_code,$status_text='')
  {
    $this->status_code=$status_code;
    $this->status_text=$status_text;
  }

//HTTPヘッダ（ユーザー情報、発生源などの追加情報）を格納
  public function setHttpHeader($name,$value)
  {
    $this->http_headers[$name]=$value;
  }
}
?>