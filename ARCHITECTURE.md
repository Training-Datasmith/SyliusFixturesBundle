# Architecture: SyliusFixturesBundle

## Purpose

Symfony bundle for loading test and demo fixtures in Sylius applications. Organises fixtures into named suites, supports before/after listeners, and integrates with Doctrine purgers for database cleanup.

## Directory Structure

```
src/
  Sylius_Fixtures_Bundle.php              Bundle entry point
  DependencyInjection/
    Configuration.php                      Suite + fixture configuration tree
    Sylius_Fixtures_Extension.php          Loads service definitions, maps suite config
    Compiler/
      Fixture_Registry_Pass.php            Collects tagged fixture services
      Listener_Registry_Pass.php           Collects tagged listener services
  Fixture/
    Fixture_Interface.php                  Contract: getName(), load(options)
    Abstract_Fixture.php                   Base class with OptionsResolver integration
    Fixture_Registry.php / Interface       Stores fixtures by name
    Fixture_Not_Found_Exception.php
  Listener/
    Listener_Interface.php                 Marker interface for suite lifecycle listeners
    After_Suite / Before_Suite / After_Fixture / Before_Fixture listener interfaces
    Abstract_Listener.php                  Base listener with OptionsResolver
    Logger_Listener.php                    Logs fixture/suite start+finish
    ORM/MongoDB/PHPCR Purger listeners     Clear database before/after suite
    Suite_Loader_Listener.php              Loads suite configuration at runtime
    Fixture_Event.php / Suite_Event.php    Event objects for listener callbacks
  Loader/
    Fixture_Loader.php                     Loads a single fixture with merged options
    Hookable_Fixture_Loader.php            Wraps loader, fires Before/AfterFixture events
    Suite_Loader.php                       Iterates fixtures in a suite
    Hookable_Suite_Loader.php              Fires Before/AfterSuite events
  Suite/
    Suite.php                              DTO: name, fixtures list with options
    Suite_Factory.php                      Builds Suite from configuration array
    Lazy_Suite_Registry.php                Lazy-loads suite configurations from DI parameters
    Priority_Queue.php                     Priority-ordered fixture execution queue
  Command/
    Fixtures_Load_Command.php              CLI: load named suites
    Fixtures_List_Command.php              CLI: list available fixtures
  Resources/config/services/              PHP-format service definitions
```

## Key Design Decisions

- **Suite-based organisation**: Fixtures are grouped into named suites that can be loaded independently. This supports different fixture sets for test vs. demo scenarios.
- **Listener lifecycle**: Before/after hooks at both the suite and individual fixture level allow setup/teardown without coupling fixture classes to database management.
- **Options per fixture**: Each fixture in a suite config can override options (e.g., quantity, locale) without creating a new fixture class.
- **Priority queue**: Fixtures within a suite execute in priority order so fixtures that depend on others (e.g., products before orders) can declare their position.

## Extension Points

- Implement `Fixture_Interface` and tag as `sylius_fixtures.fixture` to register a custom fixture.
- Implement any listener interface and tag as `sylius_fixtures.listener` to add lifecycle hooks.
- Define suites in `config/packages/sylius_fixtures.yaml` with per-fixture option overrides.

## Dependency Flow

```
bin/console sylius:fixtures:load my_suite
  -> Suite_Registry::get('my_suite') -> Suite DTO
  -> Hookable_Suite_Loader::load(suite)
    -> BeforeSuite listeners
    -> foreach fixture in priority order:
      -> Hookable_Fixture_Loader::load(fixture, options)
        -> BeforeFixture listeners
        -> Fixture_Loader::load(fixture, options)
          -> FixtureInterface::load(resolvedOptions)
        -> AfterFixture listeners
    -> AfterSuite listeners
```
