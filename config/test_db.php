<?php
// test database! Important not to run tests on production or development databases
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/tests/_data/database.sqlite',
];
