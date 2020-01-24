module.exports = {
    '**/*.php': [
        (filenames) => filenames.map(filename => `php ./vendor/bin/phpstan analyse --error-format=table --memory-limit=1G --paths-file=app '${filename}'`),
        (filenames) => filenames.map(filename => `php ./vendor/bin/phpmd ${filename} ansi phpmd.xml --suffixes php`),
        (filenames) => filenames.map(filename => `php ./vendor/bin/phpcs --colors --tab-width=4 --encoding=utf-8 --extensions=php --report=full --report-width=auto '${filename}'`),
        (filenames) => filenames.map(filename => `php ./vendor/bin/phpcpd --fuzzy --no-interaction --ansi --progress --min-lines=5 --min-tokens=70 ${filename}`),
    ],
    'resources/**/*.{js,jsx}': filenames => filenames.map(filename => `npm run --silent lint:js -- '${filename}'`),
    '**/*.+(js|jsx|css|less|scss|ts|tsx|md)': filenames => filenames.map(filename => `npx prettier -- '${filename}'`),
}
