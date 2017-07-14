Change Log: `yii2-date-range`
=============================

## Version 1.6.7

**Date:** 12-Jul-2016

- (enh #58): Add support for separate start and end attributes and inputs.
- (enh #59): Add Hungarian Translations.
- (enh #61): Add Dutch Translations.
- (enh #62): Add Romanian Translations.
- Add branch alias for dev-master latest release.
- (bug #65): Correct moment `weekdaysStart` to `weekdaysMin`.
- (enh #67): Parse input change correctly when range input value is cleared.
- (enh #68): Update to latest release of bootstrap-daterangepicker plugin and moment library.
- (bug #70): More better attribute and input options parsing.
- (enh #71): Add Thai translations.
- (bug #73): Correct dependency for `DateRangePickerAsset` and `LanguageAsset`.
- (bug #74): Correct asset bundle dependency.
- (bug #75): Correct code for PHP 5.5.
- (bug #76, #77, #78, #79): Correct dependency for `DateRangePickerAsset`.

## Version 1.6.6

**Date:** 11-Jan-2016

- (enh #55): Enhancements for PJAX based reinitialization. Complements enhancements in kartik-v/yii2-krajee-base#52 and kartik-v/yii2-krajee-base#53.
- (enh #56): Update to latest version of bootstrap-daterangepicker.

## Version 1.6.5

**Date:** 22-Oct-2015

- (enh #52): New property `autoUpdateOnInit` to prevent plugin triggering change due to `pluginOptions['autoUpdateInput']` default setting.
- (enh #53): Added correct German translations.

## Version 1.6.4

**Date:** 19-Oct-2015

- (enh #41): Add Simplified Chinese translations.
- (enh #43): Add Slovak translations.
- (enh #51): Update to latest release of bootstrap-datarangepicker plugin.

## Version 1.6.3

**Date:** 22-May-2015

- (enh #31): Add Ukranian translations.
- (enh #32): Add Portugese translations.
- (enh #36): Add Polish translations.
- (enh #38): Update to latest release of bootstrap-datarangepicker plugin.
- (enh #40): Update moment library and locales.

## Version 1.6.2

**Date:** 02-Mar-2015

- (enh #27): Correct initial value initialization for all cases.
- (enh #28): Upgrade to latest release of bootstrap-daterangepicker plugin.
- Set copyright year to current.
- (enh #29): Improve validation to retrieve the right translation messages folder.

## Version 1.6.1

**Date:** 16-Feb-2015

- (enh #27): Correct initial value initialization for all cases.
- (enh #28): Upgrade to latest release of bootstrap-daterangepicker plugin.
- Set copyright year to current.

## Version 1.6.0

**Date:** 12-Jan-2015

- (enh #22): Estonian translation for kvdrp.php
- (enh #23): Russian translations updated.
- Code formatting updates as per Yii2 standards.
- Revamp to use new Krajee base InputWidget and TranslationTrait.

## Version 1.5.0

**Date:** 29-Nov-2014

- (enh #20): Enhance language locale file parsing and registering
    - Remove `_localeLang` property
    - Rename `locale` folder to `locales` to be consistent with `datepicker` and `datetimepicker` plugins
    - Utilize enhancements in krajee base [enh #9](https://github.com/kartik-v/yii2-krajee-base/issues/9) and  [enh #10 ](https://github.com/kartik-v/yii2-krajee-base/issues/10) 
    - Update `LanguageAsset` for new path

## Version 1.4.0

**Date:** 25-Nov-2014

- (enh #17): Updated Russian translations
- (bug #18): Plugin data attributes not set because of input rendering sequence.
- (enh #19): Enhance widget to use updated plugin registration from Krajee base 

## Version 1.3.0

**Date:** 21-Nov-2014

- (enh #7): Added Russian Translations
- (enh #12): Added Spanish Translations
- (enh #13): Update moment.js related range initializations.
- (enh #14): Update moment library to latest release.
- (enh #15): Revamp widget to remove dependency on custom locale JS files enhancement
- (enh #16): Update Lithunian translations and create German translations.

## Version 1.2.0

**Date:** 20-Nov-2014

- (bug #11): Fix bug in daterangepicker.js for duplicate dates in Dec 2013.
- Upgrade to latest plugin release 1.3.16 dated 12-Nov-2014.

## Version 1.1.0

**Date:** 10-Nov-2014

- PSR4 alias change
- Set dependency on Krajee base components
- Set release to stable

## Version 1.0.0

**Date:** 09-May-2014

- Initial release