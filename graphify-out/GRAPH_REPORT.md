# Graph Report - .graphify_scope  (2026-05-05)

## Corpus Check
- 17 files · ~13,843 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 28 nodes · 35 edges · 6 communities (4 shown, 2 thin omitted)
- Extraction: 77% EXTRACTED · 20% INFERRED · 3% AMBIGUOUS · INFERRED: 7 edges (avg confidence: 0.76)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_UI Shell and Assets|UI Shell and Assets]]
- [[_COMMUNITY_Laravel Scaffold|Laravel Scaffold]]
- [[_COMMUNITY_Auth Data Layer|Auth Data Layer]]
- [[_COMMUNITY_Testing Layer|Testing Layer]]
- [[_COMMUNITY_Cache and Queue|Cache and Queue]]
- [[_COMMUNITY_Routing Layer|Routing Layer]]

## God Nodes (most connected - your core abstractions)
1. `Laravel Scaffold` - 4 edges
2. `Auth Data Layer` - 4 edges
3. `UI Shell` - 3 edges
4. `Asset Pipeline` - 3 edges
5. `Testing Layer` - 3 edges
6. `User` - 3 edges
7. `UserFactory` - 3 edges
8. `Routing Layer` - 2 edges
9. `Cache and Queue Layer` - 2 edges
10. `DatabaseSeeder` - 2 edges

## Surprising Connections (you probably didn't know these)
- `Controller` --conceptually_related_to--> `Laravel Scaffold`  [INFERRED]
  app/Http/Controllers/Controller.php → README.md
- `AppServiceProvider` --conceptually_related_to--> `Laravel Scaffold`  [INFERRED]
  app/Providers/AppServiceProvider.php → README.md
- `Create Users Table` --shares_data_with--> `User`  [INFERRED]
  database/migrations/0001_01_01_000000_create_users_table.php → app/Models/User.php
- `UserFactory` --rationale_for--> `Auth Data Layer`  [EXTRACTED]
  database/factories/UserFactory.php → app/Models/User.php
- `DatabaseSeeder` --rationale_for--> `Auth Data Layer`  [EXTRACTED]
  database/seeders/DatabaseSeeder.php → app/Models/User.php

## Hyperedges (group relationships)
- **Laravel Stack** — readme_md, composer_json, package_json, laravel_scaffold [INFERRED 0.85]
- **UI Experience** — web_routes, welcome_view, dashboard_view, machine_management_view, ui_shell [INFERRED 0.85]
- **Data and Tests** — user_model, user_factory, database_seeder, create_users_table, feature_example_test [INFERRED 0.85]

## Communities (6 total, 2 thin omitted)

### Community 1 - "Laravel Scaffold"
Cohesion: 0.4
Nodes (4): AppServiceProvider, Controller, Laravel Scaffold, README

### Community 2 - "Auth Data Layer"
Cohesion: 0.7
Nodes (5): Auth Data Layer, Create Users Table, DatabaseSeeder, UserFactory, User

### Community 3 - "Testing Layer"
Cohesion: 0.67
Nodes (4): Feature Example Test, Testing Layer, TestCase, Unit Example Test

### Community 4 - "Cache and Queue"
Cohesion: 0.67
Nodes (3): Cache and Queue Layer, Create Cache Table, Create Jobs Table

## Ambiguous Edges - Review These
- `Asset Pipeline` → `app.js`  [AMBIGUOUS]
  resources/js/app.js · relation: rationale_for

## Knowledge Gaps
- **5 isolated node(s):** `README`, `Controller`, `AppServiceProvider`, `Create Cache Table`, `Create Jobs Table`
  These have ≤1 connection - possible missing edges or undocumented components.
- **2 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **What is the exact relationship between `Asset Pipeline` and `app.js`?**
  _Edge tagged AMBIGUOUS (relation: rationale_for) - confidence is low._
- **Why does `Feature Example Test` connect `Testing Layer` to `UI Shell and Assets`?**
  _High betweenness centrality (0.094) - this node is a cross-community bridge._
- **Are the 2 inferred relationships involving `Laravel Scaffold` (e.g. with `Controller` and `AppServiceProvider`) actually correct?**
  _`Laravel Scaffold` has 2 INFERRED edges - model-reasoned connections that need verification._
- **What connects `README`, `Controller`, `AppServiceProvider` to the rest of the system?**
  _5 weakly-connected nodes found - possible documentation gaps or missing edges._