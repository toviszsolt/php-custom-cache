# php-custom-cache
Read/Write/Purge Custom Cache Files. Cache folder will be made in document root: `/.cache`.
All cache files and cache folders will be made in this folder.
You can separate cache files by type if you set cache sub-folder eg: `html`, `json`, `obj`

# Requirements
Requires `PHP5`, no extra PHP extension requires.

# Installation
Download & Include `Cache.php` PHP Class File.

# Example
```php
/* String Caching */
$data = '<html>this is a cached string</html>'; // Set Content
Cache::write( $data, 'sample.html', 'html' ); // Write Content to Cache
$html = Cache::read( 'sample.html', 'html' ); // Read Content from Cache

/* Object Caching */
$obj = new StdClass(); // Set Class
$obj->prop = 1; // Set Property of Class
Cache::write( serialize($obj), 'sample.obj', 'obj' ); // Write Object to Cache (__sleep)
$sample_obj = unserialize( Cache::read( 'sample.obj', 'obj' ) ); // Read Object from Cache (__wakeup)

/* Array Caching */
$array = [0,1,2,3,4,5]; // Set Array
Cache::write( json_encode($array), 'sample.json', 'json' ); // Write Array to Cache
$sample_arr = json_decode( Cache::read( 'sample.json', 'json' ), true ); // Read Array from Cache

/* Remove Cache */
Cache::remove( 'sample.html', 'html' );
Cache::remove( 'sample.obj', 'obj' );
Cache::remove( 'sample.json', 'json' );
```

# Documentation
```php
// Cache Dir in DOCROOT
public static string $cache_dir = '.cache/'
```

```php
// Write data to Cache file
public static function write( string $data, string $filename, string $dir )

// Parameters
$data // Data to write
$filename // Cache filename
$dir //Cache subdir name .cache/subdir/filename
```

```php
// Read data from Cache file
public static function read( string $filename, string $dir )

// Parameters
$filename //Cache filename
$dir //Cache subdir name .cache/subdir/filename

// Return
string Cached data
```

```php
// Remove Cache file
public static function remove( string $filename, string $dir )

// Parameters
$filename // Cache filename
$dir // Cache subdir name .cache/subdir/filename
```
