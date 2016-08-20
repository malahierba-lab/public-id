# Laravel Public ID

A simple and (almost) automatic short ids (like youtube ids) generator for your laravel projects. Powered by Hashids project (and malahierba dev team)

## Installation

Add in your composer.json:

    {
        "require": {
            "malahierba-lab/public-id": "1.*"
        }
    }

Then you need run the `composer update` command.

**Very Important**: in composer.json use the "1.*" notation, not the ">1". If in future releases we change the conversion tool, you can loose your old public id values. For prevent this, always stay in the same mayor version.

## Use

After Public ID installation, you must add the trait in any model which you want get public id functionality.

Example for Post Model:

    <?php namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Malahierba\PublicId\PublicId;
    
    class Post extends Model {
    	use PublicId;
    	
    	//your code...

After that, you can setup the static variables to define the settings for the publicID: `public_id_salt`, `public_id_min_length`, `public_id_alphabet`, in previous example:

    <?php namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Malahierba\PublicId\PublicId;
    
    class Post extends Model {
    	use PublicId;
    	
    	static protected $public_id_salt = 'some_string_for_salt_your_ids';

        static protected $public_id_min_length = 6; // min length for your generated short ids.
        
        static protected $public_id_alphabet = 'ABCDEFGHIJKLM'; // Only letters A-M
    	
    	//your code...

There are 4 predefined alphabets you can use.  Setting the `public_id_alphabet` variable to 'upper_alphanumeric', 'upper_alpha', 'lower_alphanumeric', 'lower_alpha' will use those predefined alphabets:

    upper_alphanumeric => ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789
    upper_alpha => ABCDEFGHIJKLMNOPQRSTUVWXYZ
    lower_alphanumeric => abcdefghijklmnopqrstuvwxyz0123456789
    lower_alpha => abcdefghijklmnopqrstuvwxyz

That's all. Now you can use the Public ID functionality in your Post Model:

Get the Public ID (a.k.a. short id) for a model:

    $short_id =  $post->public_id;

Get a model based on a public id string

    $post = Post::findByPublicId($public_id);
    
Get the original ID with the public id string

    $original_id = Post::publicIdDecode($public_id);

## Big numbers

The max ID than can be managed by default is a billion (1.000.000.000). But, depending of your environment this number could be bigger. For test the max ID in your environment setup you can use the `testPublicIdMaxInt` function:

    $max_id = Post::testPublicIdMaxInt();
    
## Licence

This project has MIT licence. For more information please read LICENCE file.
