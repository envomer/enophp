<?php declare(strict_types=1);

use Eno\Parser;

describe('integer loader', function() {
  $examples = [
    '42'       => 42,
    '-42'      => -42,
    '42.0'     => false,
    '42,0'     => false,
    '4 2'      => false,
    'fortytwo' => false
  ];

  foreach($examples as $value => $result) {
    describe($value, function() use($value, $result) {
      beforeAll(function() use($value) {
        $this->document = Parser::parse("value: {$value}");
      });

      if($result === false) {
        it('throws the expected error', function() use($value) {
          $error = interceptValidationError(function() {
            $this->document->integer('value');
          });

          expect($error)->toMatchErrorSnapshot("spec/loaders/snapshots/integer_{$value}.snap.error");
        });
      } else {
        it("returns {$result}", function() use($result) {
          expect($this->document->integer('value'))->toBe($result);
        });
      }
    });
  }
});
