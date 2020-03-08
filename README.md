# Menu Module

### Types
When creating a [`LinkTypeExtension`](src/Type/LinkTypeExtension.php) in PHP, you can also create a corresponding link type in JS/TS. These JS types are used to render the link type.

You can check a examples of this at
- [`url_link_type-extension`](addons/label_link_type-extension). This extension uses the default JS type. (check `lib`)
- [`label_link_type-extension`](addons/label_link_type-extension). This extension uses a custom JS type. (check `lib`)

So if create a custom [`LinkTypeExtension`](src/Type/LinkTypeExtension.php)
- You either let it render by using the default JS type
- Or you let it render using a custom JS type
