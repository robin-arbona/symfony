# Serveur

```
symfony server:start
```

# Entity

## Create entity

```
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Access / use entities :

### Insert into db and check for type erros

you can fetch the EntityManager via $this->getDoctrine()
or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)

```
$entityManager = $this->getDoctrine()->getManager();
$product = new Product();
$product->setName('Keyboard');
$product->setPrice(1999);
$product->setDescription('Ergonomic and stylish!');
```

tell Doctrine you want to (eventually) save the Product (no queries yet)

```
$entityManager->persist($product);
```

actually executes the queries (i.e. the INSERT query)

```
$entityManager->flush();
```

Check for errors with type.
Use autowiring to get: ValidatorInterface $validator

```
$errors = $validator->validate($product);
```

### Fetch from db

```
$product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
```

or by using autowiring, get directly the Repo : ProductRepository $respository and after

```
$product = $repository->find($id);
$product = $repository->findOneBy(['name' => 'Keyboard']);
$products = $repository->findAll();
```

### Update

Using Doctrine to edit an existing product consists of three steps:

1. fetching the object from Doctrine;
2. modifying the object;
3. calling flush() on the entity manager.

### Deleting

```
$entityManager->remove($product);
$entityManager->flush();
```

# Controller

## Create Controller

php bin/console make:controller ProductController

php bin/console make:crud Product

# Query db

php bin/console doctrine:query:sql 'SELECT \* FROM product'

# Bundle

## Fixture

```
composer require --dev doctrine/doctrine-fixtures-bundle
php bin/console make:fixtures

php bin/console doctrine:fixtures:load
```

or load specific fixture

```
php bin/console doctrine:fixtures:load --group=UserFixture
```

# Security

Creation d'utilisateurs / droit
ressource :
http://www.lsis.org/elmouelhia/courses/php/sf/coursSymfonyUtilisateurs.pdf

```
composer require symfony/security-bundle
php bin/console make:user
```
