# HKIDUtil
PHP Utility functions designed to help tasks related to Hong Kong Identity Card (HKID).

## Features
* Support two-letter prefix (e.g. AB987654(2))
* For HKID input, parentheses are optional 

## Requirement
* PHP 5.3+

## Functions
* getCheckDigit - Get the Check Digit of HKID
```
char HKIDUtil::getCheckDigit(string $id)
```
* validateHKID - Validate HKID format
```
bool HKIDUtil::validateHKID(string $id)
```
* randomHKID - Generate random HKID
```
string HKIDUtil::randomHKID(bool $hasParentheses=true)
```
* validateDate - Validate date format in 'dd-mm-yyyy' or 'dd/mm/yyyy'
```
bool HKIDUtil::validateDate(string $date)
```

## Usage
Include the utility function file and call the static functions.
```PHP
require_once("HKIDUtil.php");
```

Get the Check Digit of a HKID
```PHP
$testID = 'C123456';
echo(HKIDUtil::getCheckDigit($testID));  // returns '9'
```

Validate HKID format, check digit parentheses are optional
```PHP
var_dump(HKIDUtil::validateHKID('AB987654(2)'));   // bool(true)
if(HKIDUtil::validateHKID('AB9876542')){ echo 'valid'; }     //returns 'valid'
```

Generate random HKID
```PHP
echo(HKIDUtil::randomHKID());     // returns e.g. 'LA654668(9)'

for($i = 0; $i < 3; $i++){
    echo(HKIDUtil::randomHKID(0)) . PHP_EOL;
}
// returns e.g. 
// 'Q2127047'
// 'J9009792'
// 'BA1196657'
```

Validate date format in 'dd-mm-yyyy' or 'dd/mm/yyyy'
```PHP
var_dump(HKIDUtil::validateDate('31-12-1969'));     // bool(true)
var_dump(HKIDUtil::validateDate('01/01/1970'));     // bool(true)
var_dump(HKIDUtil::validateDate('1/1/1970'));       // bool(true)
var_dump(HKIDUtil::validateDate('30/02/1970'));     // bool(false)
```

## License
See the LICENSE file for license rights and limitations (MIT).

## Reference
This HKID validation formula is developed based on the information from Wikipedia.   
[維基百科, 香港身份證 (Wikipedia, Hong Kong Identity Card)](https://zh.wikipedia.org/w/index.php?title=%E9%A6%99%E6%B8%AF%E8%BA%AB%E4%BB%BD%E8%AD%89&variant=zh-hk#.E6.A0.A1.E9.A9.97.E7.A2.BC)

## Contribution
Pull request and issue report are welcome.
