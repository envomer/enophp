<?php declare(strict_types=1);

use Eno\{Errors\ParseError, Parser};

describe('Tokenization::unterminatedEscapedName', function() {
  beforeAll(function() {
    $this->error = interceptParseError(function() {
      $input = '`language: eno';

      Parser::parse($input);
    });
  });

  it('provides a correct error', function() {
    expect($this->error)->toMatchErrorSnapshot('spec/errors/tokenization/snapshots/unterminated_escaped_name.snap.error');
  });
});
