<?php

/**
 * Read/Write Cache files
 *
 * Cache folder will be made in document root: <i>/.cache</i>
 * All cache files and cache folders will be made in this folder.
 * You can separate cache files by type if you set cache sub-folder eg: <i>html</i>, <i>json</i>, <i>obj</i>
 *
 * <i>Examples:</i>
 * <pre>
 * // /.cache/cache-subdir/cache-file-name
 * Cache::write( $data, 'cache-file-name', 'cache-subdir' );
 * $data = Cache::read( 'cache-file-name', 'cache-subdir' );
 * </pre>
 * <pre>
 * // /.cache/obj/object_m01.obj
 * Cache::write( serialze($object), 'object_m01.obj', 'obj' );
 * $object = unserialze( Cache::read( 'object_m01.obj', 'obj' ) );
 * </pre>
 * <pre>
 * // /.cache/json/cache-file-name.json
 * Cache::write( json_encode($array), 'cache-file-name.json', 'json' );
 * $array = json_decode( Cache::read( 'cache-file-name.json', 'json' ), true );
 * </pre>
 *
 * @author Zsolt Tovis
 * @copyright Copyright (c) 2016, Zsolt Tovis
 */
class Cache {

  /**
   * @var string Cache Directory
   */
  public static $cache_dir = '.cache/';

  /**
   * Initialize Cache
   */
  public function __construct() {

    $dir = $_SERVER['DOCUMENT_ROOT'] . '/' . self::$cache_dir;

    /* Create cache dir */
    if ( !file_exists( $dir ) ) {
      mkdir( $dir, 0777, true );
    }

    /* Protect cache dir */
    if ( !file_exists( $dir . '.htaccess' ) ) {
      file_put_contents( $dir . '.htaccess', "Order Allow,Deny\nDeny from all" );
    }

  }

  /**
   * Write data to Cache file
   *
   * @param string $data Data to write
   * @param string $filename Cache filename
   * @param string $dir Cache subdir name .cache/subdir/filename
   */
  static public function write( $data, $filename, $dir ) {

    $file = $_SERVER['DOCUMENT_ROOT'] . '/' . self::$cache_dir . $dir . '/' . basename( $filename );

    /* Create subdir */
    if ( !file_exists( dirname( $file ) ) ) {
      mkdir( dirname( $file ), 0777, true );
    }

    /* Write cache file */
    file_put_contents( $file, $data, LOCK_EX );

  }

  /**
   * Read data from Cache file
   *
   * @param string $filename Cache filename
   * @param string $dir Cache subdir name .cache/subdir/filename
   * @return string Cached data
   */
  static public function read( $filename, $dir ) {

    $file = $_SERVER['DOCUMENT_ROOT'] . '/' . self::$cache_dir . $dir . '/' . basename( $filename );

    if ( !file_exists( $file ) ) {
      return false;
    }

    return file_get_contents( $file );

  }

  /**
   * Remove Cache file
   *
   * @param string $filename Cache filename
   * @param string $dir Cache subdir name .cache/subdir/filename
   * @return void
   */
  static public function remove( $filename, $dir ) {

    $file = $_SERVER['DOCUMENT_ROOT'] . '/' . self::$cache_dir . $dir . '/' . basename( $filename );

    if ( file_exists( $file ) ) {
      unlink( $file );
    }

    return true;

  }

}
