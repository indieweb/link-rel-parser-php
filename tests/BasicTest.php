<?php
class BasicTest extends PHPUnit_Framework_TestCase {

  public function setUp() {
  }

  private function _testEquals($expected, $headers) {
    $result = IndieWeb\http_rels($headers);
    $this->assertEquals($expected, $result);
  }

  public function testExample() {
    $this->_testEquals(array(
      'd' => array('http://example.org/query?a=b,c'),
      'e' => array('http://example.org/query?a=b,c'),
      'f' => array('http://example.org/'),
    ), "Link: <http://example.org/query?a=b,c>; rel=\"d e\", <http://example.org/>; rel=f");
  }

  public function testMultipleAttributes() {
    $this->_testEquals(array(
      'foo' => array('http://example.org/'),
    ), "Link: <http://example.org/>; rel=\"foo\"; title=\"Example\"");
  }

  public function testUnusualCaseLinkHeader() {
    $this->_testEquals(array(
      'foo' => array('http://example.org/')
    ), "LinK: <http://example.org/>; rel=\"foo\"; title=\"Example\"");
  }

  public function testLinkNoRelValue() {
    $this->_testEquals(array(
    ), "Link: <http://example.org/>; title=\"Example\"");
  }

  public function testAaronParecki() {
    $this->_testEquals(array(
      'http://webmention.org/' => array('http://aaronparecki.com/webmention.php'),
      'indieauth' => array('https://indieauth.com'),
      'pingback' => array('http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php')
    ), "HTTP/1.1 200 OK
Server: nginx/1.0.14
Date: Sat, 26 Oct 2013 01:40:11 GMT
Content-Type: text/html; charset=UTF-8
Connection: keep-alive
Link: <https://indieauth.com>; rel=\"indieauth\"
X-Pingback: http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php
Link: <http://aaronparecki.com/webmention.php>; rel=\"http://webmention.org/\"");
  }

  public function testBarryFrost() {
    $this->_testEquals(array(
      'webmention' => array('http://barryfrost.com/webmention'),
    ), "HTTP/1.1 200 OK
Cache-Control: max-age=0, private, must-revalidate
Content-length: 19600
Content-Type: text/html; charset=utf-8
Date: Sat, 26 Oct 2013 01:49:21 GMT
Link: <http://barryfrost.com/webmention>; rel=\"webmention\"");
  }

  
}
