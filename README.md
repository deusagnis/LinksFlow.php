# LINKSFLOW core

## About
This package is core of backend logic of [LINKSFLOW](https://mggflow.in/linksflow) service.

## Usage
To install:
```
composer require mggflow/linksflow
```

Example of creation Link:
```
// Fields of Link as (object)[...].
// Implements Interfaces/LinkData.
$linkData = new LinkData();

$createLink = new CreateLink($linkData, $link);

try {
    $link->id = $createLink->create();
} catch (IncorrectLinkOptions | AliasNonUnique $exception) {
    throw $exception;
}
```