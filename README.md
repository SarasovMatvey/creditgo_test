## Installation:

1. Download repository:
``` bash
  git clone git@github.com:SarasovMatvey/creditgo_test.git
```

2. Go to project directory:
``` bash
cd creditgo_test
```

3. Install dependencies:

``` bash
composer install
```

4. Generate binary tree:

``` bash
docker-compose run bst --indexField="name"
```

5. Run search:

``` bash
docker-compose run search --searchField="name" --searchValue="Adhi Kot"
```

6. Run search without binary tree index:

``` bash
docker-compose run search --searchField="name" --searchValue="Adhi Kot" --useBst="false"
```
