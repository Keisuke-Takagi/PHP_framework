<?php

// 理解すべきコードまだわからん
class Object
{
    // /**
    //  * @var \Closure[]
    //  */
    private $methods = [];

    private $foo = 'これValue';

    public function __set($name,  $method)
    // $nameにgetFoo
    {
      var_dump($name);
      var_dump($method);
      // クロージャーにbindTo()をしているため他のスコープでも使える
        $this->methods[$name] = $method->bindTo($this, self::class);
    }
    public function __call(string $name, $arguments)
    {
      var_dump($arguments);
        if (!array_key_exists($name, $this->methods)) {
            throw new \BadMethodCallException(
                'Call to undefined method ' . __CLASS__ . "::$name()"
            );
        }
        return $this->methods[$name](...$arguments);
    }
}

// オブジェクトを作る
$object = new Object();

// 後からメソッドを追加する
$object->getFoo = function () {
    return $this->foo;
};

// 追加したメソッドを呼び出す
echo $object->getFoo();




// echo "くろーじゃについて\n";

// class MyClass
// {
//     private $foo = "Foo";

//     public function getFoo()
//     {
//       // オブジェクトのメソッド化によって呼び出しの記述を減らしている
//         return function() { return $this->foo; };
//     }
// }

// $obj = new MyClass();
// $foo = $obj->getFoo();
// echo $foo() ."\n" ;

// echo "バインドとくろーじゃについて\n";
// class A {
//   function __construct($val) {
//       $this->val = $val;
//   }
//   function getClosure() {
//       // このオブジェクトとスコープにバインドしたクロージャを返します。
//       return function() { return $this->val; };
//   }
// }

// $ob1 = new A(1);
// $ob2 = new A(2);

// $cl = $ob1->getClosure();
// echo $cl(), "\n";
// $cl = $cl->bindTo($ob2);
// echo $cl(), "\n";
?>
<?php
    // echo "\n マジックメソッド__get,  __set\n\n";
    // class Property{
    //     public $food;
    //     public function __set($name, $value){
    //         echo "__set()なう\n";
    //     }

    //     public function __get($name){
    //       echo "__get()なう\n";
    //       //連想配列から$nameに対応する$valueを返す
    //       return $this->drinker[$name];
    //     }
    // }

    // $pro = new Property();
    // $pro->food = "さんまの塩焼き";
    // var_dump($pro->food);
    // $pro->drink = "いろはす";
    // var_dump($pro->drink);
    // $pro->drink = "ポカリ";
    // var_dump($pro->drink);

    $opts = array(
        'http'=>array(
          'method'=>"GET",
          'header'=>"Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
        )
      );
      
      $context = stream_context_create($opts);
      
      /* 上のヘッダと共に http リクエストを www.example.com に対して
         送出します */
    echo __DIR__;

?>
