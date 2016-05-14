<?php

namespace spec\Mi11er\Library\Text\Formatters;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TitleCaseFormatterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {

        $this->shouldHaveType('Mi11er\Library\Text\Formatters\TitleCaseFormatter');
    }
    /**
     *  @dataProvider titleCaseExamples
     */
    public function it_converts_text_to_title_case($inputValue, $expectedValue)
    {
        $this->format($inputValue)->shouldReturn($expectedValue);
    }

    /**
     * Example test cases for the toTitleCcase method
     */
    public function titleCaseExamples()
    {
        return  [
          [
          'follow step-by-step instructions',
          'Follow Step-by-Step Instructions',
          ],
          [
          'this sub-phrase is nice',
          'This Sub-Phrase Is Nice',
          ],
          [
          'catchy title: a subtitle',
          'Catchy Title: A Subtitle',
          ],
          [
          'catchy title: "a quoted subtitle"',
          'Catchy Title: "A Quoted Subtitle"',
          ],
          [
          'catchy title: “‘a twice quoted subtitle’”',
          'Catchy Title: “‘A Twice Quoted Subtitle’”',
          ],
          [
          '"a title inside double quotes"',
          '"A Title Inside Double Quotes"',
          ],
          [
          'all words capitalized',
          'All Words Capitalized',
          ],
          [
          'small words are for by and of lowercase',
          'Small Words Are for by and of Lowercase',
          ],
          [
          'a small word starts',
          'A Small Word Starts',
          ],
          [
          'a small word it ends on',
          'A Small Word It Ends On',
          ],
          [
          'do questions work?',
          'Do Questions Work?',
          ],
          [
          'multiple sentences. more than one.',
          'Multiple Sentences. More Than One.',
          ],
          [
          'Ends with small word of',
          'Ends With Small Word Of',
          ],
          [
          'double quoted "inner" word',
          'Double Quoted "Inner" Word',
          ],
          [
          "single quoted 'inner' word",
          "Single Quoted 'Inner' Word",
          ],
          [
          'fancy double quoted “inner” word',
          'Fancy Double Quoted “Inner” Word',
          ],
          [
          'fancy single quoted ‘inner’ word',
          'Fancy Single Quoted ‘Inner’ Word',
          ],
          [
          'this vs. that',
          'This vs. That',
          ],
          [
          'this vs that',
          'This vs That',
          ],
          [
          'this v. that',
          'This v. That',
          ],
          [
          'this v that',
          'This v That',
          ],
          [
          'address email@example.com titles',
          'Address email@example.com Titles',
          ],
          [
          'pass camelCase through',
          'Pass camelCase Through',
          ],
          [
          "don't break",
          "Don't Break",
          ],
          [
          'catchy title: substance subtitle',
          'Catchy Title: Substance Subtitle',
          ],
          [
          'we keep NASA capitalized',
          'We Keep NASA Capitalized',
          ],
          [
          'leave Q&A unscathed',
          'Leave Q&A Unscathed',
          ],
          [
          'Scott Moritz and TheStreet.com’s million iPhone la-la land',
          'Scott Moritz and TheStreet.com’s Million iPhone La-La Land',
          ],
          [
          'you have a http://example.com/foo/ title',
          'You Have a http://example.com/foo/ Title',
          ],
          [
          'your hair[cut] looks (nice)',
          'Your Hair[cut] Looks (Nice)',
          ],
          [
          'keep that colo(u)r',
          'Keep That Colo(u)r',
          ],
          [
          'have you read “The Lottery”?',
          'Have You Read “The Lottery”?',
          ],
          [
          'Read markdown_rules.txt to find out how _underscores around words_ will be interpreted',
          'Read markdown_rules.txt to Find Out How _Underscores Around Words_ Will Be Interpreted',
          ],
          [
          'Read markdown_rules.txt to find out how *asterisks around words* will be interpreted',
          'Read markdown_rules.txt to Find Out How *Asterisks Around Words* Will Be Interpreted',
          ],
          [
          'Notes and observations regarding Apple’s announcements from ‘The Beat Goes On’ special event',
          'Notes and Observations Regarding Apple’s Announcements From ‘The Beat Goes On’ Special Event',
          ],
          [
          'Drink this piña colada while you listen to ænima',
          'Drink This Piña Colada While You Listen to Ænima',
          ],
          [
          'capitalize hyphenated words on-demand',
          'Capitalize Hyphenated Words On-Demand',
          ],
          [
          'take them on: special lower cases',
          'Take Them On: Special Lower Cases',
          ],
          [
          '<h1>some <b>HTML</b> &amp; entities</h1>',
          '<h1>Some <b>HTML</b> &amp; Entities</h1>',
          ],
        ];
    }
}
