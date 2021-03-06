<?php

class DatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
  */
  public function run()
  {
    Eloquent::unguard();

    $this->call('UserTableSeeder');
    $this->call('ApiKeyTableSeeder');
    $this->call('TokenTableSeeder');
    $this->command->info('User table seeded successfully!');
    $this->command->info('API Key table seeded successfully!');
    $this->command->info('Token table seeded successfully!');
  }

}


class UserTableSeeder extends Seeder {

  public function run()
  {
    DB::table('users')->delete();

    User::create(array(
      '_id' => '5480c950bffebc651c8b456f',
      'email' => 'test@dosomething.org', 
      'mobile' => '5555555555',
      'password' => 'secret',
      'drupal_uid' => 123456,
      'addr_street1' => '123',
      'addr_street2' => '456',
      'addr_city' => 'Paris',
      'addr_state' => 'Florida',
      'addr_zip' => '555555',
      'country' => 'US',
      'birthdate' => '12/17/91',
      'first_name' => 'First',
      'last_name' => 'Last'
    )); 

    User::create(array(
      'email' => 'info@dosomething.org', 
      'mobile' => '5556669999',
      'password' => 'secret',
      'drupal_uid' => 456788,
      'addr_street1' => '456',
      'addr_street2' => '33',
      'addr_city' => 'Example',
      'addr_state' => 'Testing',
      'addr_zip' => '555555',
      'country' => 'US',
      'birthdate' => '12/17/91',
      'first_name' => 'John',
      'last_name' => 'Doe'
    )); 
  }

}

class ApiKeyTableSeeder extends Seeder {

  public function run()
  {
    DB::table('api_keys')->delete();

    ApiKey::create(array(
      'app_id' => '456',
      'api_key' => 'abc4324'
    ));

    ApiKey::create(array(
      'app_id' => '123',
      'api_key' => '5464utyrs'
    ));

  }

}

class TokenTableSeeder extends Seeder {

  public function run()
  {
    DB::table('tokens')->delete();

    Token::create(array(
      'key' => 'S0FyZmlRNmVpMzVsSzJMNUFreEFWa3g0RHBMWlJRd0tiQmhSRUNxWXh6cz0=',
      'user_id' => '5480c950bffebc651c8b456f'
    ));
  }

}
