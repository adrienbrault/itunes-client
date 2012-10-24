<?php

/**
 * Is this file a shame ? Yep, totaly.
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */

// See http://www.apple.com/itunes/affiliates/resources/documentation/genre-mapping.html

$genresUrl = 'http://itunes.apple.com/WebObjects/MZStoreServices.woa/ws/genres';

$result = json_decode(file_get_contents($genresUrl), true);

$flatGenres = array();
foreach ($result as $genre) {
    $flatGenres = array_merge($flatGenres, getFlatGenres($genre));
}

$className = 'Genres';
$namespace = 'AdrienBrault\ItunesClient';
$filePath = __DIR__.'/../src/AdrienBrault/ItunesClient/Genres.php';

file_put_contents($filePath, getFileContent(filterResult($result), $flatGenres, $namespace, $className));

function getFlatGenres(array $genre, $namePrefix = '')
{
    $name = normalizeText($namePrefix.$genre['name']);

    $genres = array(
        $name => (integer) $genre['id'],
    );

    if (isset($genre['subgenres'])) {
        foreach ($genre['subgenres'] as $subGenre) {
            $genres = array_merge($genres, getFlatGenres($subGenre, $name.'_'));
        }
    }

    return $genres;
}

function normalizeText($text)
{
    $text = strtoupper($text);
    $text = preg_replace('/[^A-Z_ ]/', '', $text);
    $text = str_replace(' ', '_', $text);
    $text = str_replace('__', '_', $text);

    return $text;
}

function filterResult(array $result)
{
    $filteredResult = array();

    foreach ($result as $genre) {
        $filteredResult[(integer) $genre['id']] = filterGenre($genre);
    }

    return $filteredResult;
}

function filterGenre(array $genre)
{
    $filteredGenre = array(
        'name' => $genre['name'],
        'id' => (integer) $genre['id'],
    );

    if (isset($genre['subgenres'])) {
        $filteredGenre['children'] = array();
        foreach ($genre['subgenres'] as $subGenre) {
            $filteredGenre['children'][(integer) $subGenre['id']] = filterGenre($subGenre);
        }
    }

    return $filteredGenre;
}

function getFileContent(array $genres, array $flatGenres, $namespace, $className)
{
    $classConstants = '';
    foreach ($flatGenres as $const => $id) {
        $classConstants[] = str_repeat(' ', 4).'CONST '.$const.' = '.$id.';';
    }

    $classConstants = join(PHP_EOL, $classConstants);
    $genresString = var_export($genres, true);

    return <<<TEMPLATE
<?php

namespace $namespace;

class $className
{
$classConstants

    public function getGenres()
    {
        return $genresString;
    }
}

TEMPLATE;
}
