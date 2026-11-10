# Statamic Ruby Text

Adds a ruby text button to the Bard fieldtype in Statamic. Ruby annotations display pronunciation above text, for example Japanese kana above kanji.

## Compatibility

| Addon version | Statamic version | PHP version |
| --- | --- | --- |
| 0.2.x | 6.x | 8.3+ |
| 0.1.x | 5.x | As required by Statamic 5 |

## How to Install

For Statamic 6, run this command from your site's root directory:

``` bash
composer require textandbytes/statamic-rubytext:^0.2
```

Sites still using Statamic 5 should use `textandbytes/statamic-rubytext:^0.1`.

## How to Use

Add `ruby` to the buttons configured for your Bard field. For example, in a blueprint:

```yaml
- handle: body
  field:
    type: bard
    buttons:
      - bold
      - italic
      - ruby
```

Select text in Bard, click **Ruby Text**, enter its pronunciation, and click **Apply** or press Enter. Select an existing annotation to edit it or use **Remove**. **Cancel** leaves the annotation unchanged.

## Upgrading from 0.1.x

Upgrade your site to Statamic 6 and require version `^0.2` of this addon as part of that upgrade. The stored content format and frontend HTML remain unchanged; existing annotations do not need a content migration.

After Composer updates the addon, ensure its compiled CP assets are published:

```bash
php artisan vendor:publish --provider='Textandbytes\StatamicRubytext\ServiceProvider' --force
```

The release includes compiled assets. Site owners do not need to run npm inside this addon.

## Development

In this addon's standalone checkout, use PHP 8.3+ and Node 20.19+ (20.x), or Node 22.12+:

```bash
composer install
npm ci
npm run build
composer test
```

Composer must run before npm because the JavaScript tooling comes from the installed Statamic package. To check the CP interface, install the addon in a local Statamic 6 site and publish its assets.

See [RELEASING.md](RELEASING.md) for the release process and manual test checklist.
