# Asset Control

ကုမ္ပဏီ၏ laptop, handset နှင့် အခြား asset များကို employee/operator နှင့် ချိတ်ဆက်ပြီး ရှာဖွေ၊ update၊ import/export နှင့် history စီမံရန် အသုံးပြုထားသော Laravel web application ဖြစ်သည်။

ဒီဖိုင်ကို နောက်တစ်ယောက်က project ကို လွယ်ကူစွာ run, debug နှင့် maintenance လုပ်နိုင်ရန် ရည်ရွယ်ထားသည်။

## နည်းပညာများ

- PHP `^8.1`
- Laravel `^10.10`
- MySQL (default connection)
- Laravel UI/Auth, Sanctum
- Laravel Excel / PhpSpreadsheet (`maatwebsite/excel`)
- Vite, Bootstrap 5, Sass, Axios

## Local setup

လိုအပ်ချက်များ — PHP 8.1+, Composer, Node.js/npm နှင့် MySQL/MariaDB။

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
```

`.env` ထဲတွင် အနည်းဆုံး အောက်ပါ setting များကို ကိုယ့်စက်/ server အတိုင်း ပြင်ပါ။

```dotenv
APP_NAME="Asset Control"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=asset_control
DB_USERNAME=root
DB_PASSWORD=
```

Database တစ်ခု ဖန်တီးပြီး migration run ပါ။ လက်ရှိ data ရှိပြီးသား database တွင် `migrate:fresh` မသုံးပါနှင့် — data အားလုံး ဖျက်သွားနိုင်သည်။

```bash
php artisan migrate
php artisan storage:link       # upload/storage file အသုံးပြုလျှင်
```

## Run

Development တွင် terminal နှစ်ခုဖွင့်ပြီး run လုပ်ပါ။

```bash
php artisan serve
npm run dev
```

Production asset build အတွက် —

```bash
npm run build
```

`php artisan serve` သုံးပါက ပုံမှန်အားဖြင့် `http://127.0.0.1:8000` မှ ဝင်နိုင်သည်။ Login/Auth routes များကို `routes/web.php` နှင့် `app/Http/Controllers/Auth/` တွင် ကြည့်ပါ။

## Project structure

| Path | တာဝန် |
| --- | --- |
| `app/Http/Controllers/` | Web request, validation, CRUD နှင့် import/export flow |
| `app/Models/` | Database table တစ်ခုချင်းစီ၏ Eloquent model |
| `app/Imports/` | Excel row mapping နှင့် validation |
| `app/Exports/` | Excel export |
| `app/Services/` | Dashboard/လုပ်ငန်း logic; လက်ရှိ `PendingEmployeeUpdateService` |
| `app/helpers.php` | Shared query helper များနှင့် asset history sync |
| `resources/views/` | Blade UI |
| `resources/js`, `resources/css`, `resources/sass` | Frontend source |
| `public/assets/` | Static JS/CSS, logo နှင့် import sample files |
| `routes/web.php` | Login လိုအပ်သော application routes |
| `routes/api.php` | လက်ရှိ Sanctum `/api/user` endpoint |
| `database/migrations/` | Database schema ပြောင်းလဲမှုမှတ်တမ်း |
| `app/Console/Commands/` | Artisan command များ |

## Main features

### Asset / employee management

- `LaptopAssetCodeController` သည် asset search, detail, employee assignment, remark/operator update, delete နှင့် fix-asset view ကို အဓိက ထိန်းချုပ်သည်။
- `UserController` သည် user/employee စာရင်း၊ search၊ password change နှင့် delete ကို ကိုင်တွယ်သည်။
- အများစုသော application routes များသည် `auth` middleware အောက်တွင်ရှိသည်။ Route အသစ်ထည့်ရာတွင် authorization လိုအပ်/မလိုအပ်ကို သေချာစစ်ပါ။

### Excel import/export

အသုံးပြုနေသော import flow များ —

- Main asset import: `AssetImportExcelController` → `app/Imports/AssetImport.php`
- Asset operator import: `AssetOperatorController` → `app/Imports/AssetOperator.php`
- Non-asset operator import: `NonAssetImportController` → `app/Imports/NonAssetOperator.php`
- Operator import: `OperatorController` → `app/Imports/OperatorImport.php`
- Asset export: `app/Exports/LaptopAssetCodeExport.php`

Sample Excel ဖိုင်များကို `public/assets/img/` တွင် ထားထားသည်။ Column/header ပြောင်းလဲမည်ဆိုပါက သက်ဆိုင်ရာ `Import` class ၏ `model()` နှင့် `rules()` ကို UI form မတိုင်မီ အရင်ပြင်ပါ။ Import ပြီးနောက် row count နှင့် validation error များကို စစ်ပါ။

### Pending employee chart

`app/Services/PendingEmployeeUpdateService.php` က —

1. `fix_assets` ထဲမှ `asset_type_name` သည် `laptop` သို့မဟုတ် `handset` ဖြစ်ပြီး `status = ongoing` ဖြစ်သော asset များကို ရွေးသည်။
2. Asset တစ်ခုချင်းစီ၏ နောက်ဆုံး `remarks` record ကို ကြည့်သည်။
3. နောက်ဆုံး remark တွင် `emp_id` သို့မဟုတ် `emp_name` မရှိပါက pending အဖြစ် သတ်မှတ်သည်။
4. Branch အလိုက် laptop/handset count ခွဲပြီး dashboard တွင် ပြသည်။

ဒါကြောင့် chart မမှန်ပါက `fix_assets.status`, `asset_type_name`, `purchase_date` နှင့် asset တစ်ခု၏ နောက်ဆုံး remark ကို အရင်စစ်ပါ။

### Asset history sync

Custom command သည် `app/Console/Commands/SyncAssetHistory.php` ဖြစ်သည်။

```bash
php artisan asset:sync-history
```

`syncAssetHistory()` သည် `fix_assets` ထဲရှိ `asset_code` / `asset_name` ကို `asset_histories` ထဲသို့ ထည့်ပြီး asset name ပြောင်းလဲလျှင် history အသစ်တစ်ကြောင်း ထပ်သိမ်းသည်။ ထပ်ခါထပ်ခါ run လုပ်လည်း အမည်မပြောင်းလျှင် duplicate မထည့်ပါ။

Schedule ကို `app/Console/Kernel.php` တွင် နေ့စဉ် `08:00` အဖြစ် သတ်မှတ်ထားသည်။ Server တွင် Laravel scheduler အလုပ်လုပ်ရန် cron တစ်ကြောင်း ထည့်ပါ —

```cron
* * * * * cd /path/to/asset_control && php artisan schedule:run >> /dev/null 2>&1
```

Timezone သည် server/PHP timezone နှင့် ကိုက်ညီရမည်။ မကိုက်ပါက `config/app.php` နှင့် server timezone ကို စစ်ပါ။

## Database tables

အဓိက tables များမှာ `users`, `laptop_asset_codes`, `fix_assets`, `assetfiles`, `asset_histories`, `remarks`, `operators`, `non_operators`, `non_remarks`, `branches`, `departments`, `asset_types` ဖြစ်သည်။ Schema အပြောင်းအလဲတိုင်းကို migration အသစ်အဖြစ် ထည့်ပြီး production တွင် `php artisan migrate` ဖြင့်သာ apply လုပ်ပါ။ Existing migration ကို ပြန်ပြင်ခြင်းထက် အသစ်ထပ်ရေးခြင်းက deployment အတွက် ပိုလုံခြုံသည်။

## Testing and code quality

```bash
php artisan test
vendor/bin/pint --test
```

Test များကို `tests/Feature` နှင့် `tests/Unit` တွင် ထည့်ပါ။ Import, delete, employee assignment နှင့် dashboard calculation ကဲ့သို့ data ပြောင်းလဲစေသော logic များကို ပြင်မည်ဆိုပါက အနည်းဆုံး feature test ထည့်သင့်သည်။

## Deployment checklist

1. `.env` ကို environment အလိုက် သတ်မှတ်ပြီး secret များကို source control ထဲ မထည့်ပါနှင့်။ `.env.example` သည် template သာ ဖြစ်သည်။
2. `composer install --no-dev --optimize-autoloader` နှင့် `npm run build` run ပါ။
3. Database backup ပြုလုပ်ပြီး `php artisan migrate --force` run ပါ။
4. `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache` run ပါ။
5. Web server document root ကို `public/` သို့ ချိန်ပါ။
6. `storage/` နှင့် `bootstrap/cache/` ကို web server user က write လုပ်နိုင်ကြောင်း စစ်ပါ။
7. Scheduler cron နှင့် application log (`storage/logs/laravel.log`) ကို စစ်ပါ။

## Troubleshooting

| ပြဿနာ | စစ်ဆေးရန် |
| --- | --- |
| `No application encryption key` | `php artisan key:generate` |
| Database connection error | `.env` DB setting, MySQL service, database name/user/password |
| `.env` ပြင်ပြီး effect မဖြစ် | `php artisan config:clear` သို့မဟုတ် cache ပြန်တည်ဆောက်ပါ |
| CSS/JS မပြောင်း | `npm run build` သို့မဟုတ် dev server ပြန်စပါ |
| Excel import မဝင် | file type, header names, import validation rules နှင့် `storage/logs/laravel.log` |
| History မ sync | `php artisan asset:sync-history` ကို manually run ပြီး `fix_assets` data နှင့် scheduler/cron စစ်ပါ |
| 404/403/419 | route, login session, CSRF token နှင့် `php artisan route:list` |

## Maintenance notes

- Business logic အများစုသည် `LaptopAssetCodeController` ထဲ စုနေသောကြောင့် feature အသစ်ကြီးများကို Service class သို့ ခွဲထုတ်ရန် စဉ်းစားပါ။
- Naming တွင် လက်ရှိ `deletRecord`, `deletasset` စသည့် legacy method name များရှိသည်။ Refactor လုပ်ရာတွင် route/controller နှစ်ဖက်လုံးကို တစ်ပြိုင်နက် စစ်ပြီး backward compatibility မပျက်စေရန် သတိထားပါ။
- Import template များကို `public/assets/img/` တွင် ထားထားသဖြင့် column ပြောင်းလဲမှုသည် download လုပ်သူများ၏ workflow ကို ထိခိုက်နိုင်သည်။
- Production data ကို တိုက်ရိုက်ပြင်မည့်အစား backup, migration နှင့် audited command အသုံးပြုပါ။ Delete endpoint များ များစွာရှိသောကြောင့် permission နှင့် confirmation ကို အထူးစစ်ပါ။
- Dependency update ပြုလုပ်ပြီးနောက် `composer audit`, `php artisan test`, `npm run build` နှင့် import/export smoke test ပြန်လုပ်ပါ။

## Useful commands

```bash
php artisan route:list
php artisan migrate:status
php artisan optimize:clear
php artisan asset:sync-history
tail -f storage/logs/laravel.log
```
