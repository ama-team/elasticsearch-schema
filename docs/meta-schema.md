---
title: The schema of schema
---

This section describes how the schema description looks like. While
there is validation schema that describes the very same structure, it's
not exactly human-friendly, so it's better to explain what's going on.

Please note that assembly process (process of creation resulting schema
from source discussed below) is described in 
[corresponding section](assembly).

```yaml
<ProductName>:
  requires:
    <ProductName>: ~
  versions:
    <Version>:
      requires:
        <ProductName>: <Version>
      parameters: <ParameterMap>
      mapping:
        parameters: <ParameterMap>
        types:
          <TypeName>: <Type>
      index:
        parameters: <ParameterMap>
        analysis:
          parameters: <ParameterMap>
          analyzers:
            parameters: <ParameterMap>
            types:
              <AnalyzerName>: <Analyzer>
          tokenizers:
            parameters: <ParameterMap>
            types:
              <TokenizerName>: <Tokenizer>
          token_filters:
            parameters: <ParameterMap>
            types:
              <TokenFilterName>: <TokenFilter>
        settings:
          <SettingName>: <Setting>
      configuration:
        <OptionName>: <Option>  
```

All `*Name` types are just strings, and `ProductName` stands for
ES-related software - `elasticsearch` itself or just some plugin.
Version is represented as string as well (e.g. `6.0.0`).

This schema ***may*** expand in future to include queries, aggregations
and other ElasticSearch entities.

## References

Every item in the schema may be referenced from other file using 
standard JSON pointer:

```yaml
elasticsearch:
  6.0.0:
    $ref: 'elasticsearch/6.0.0.yml#'
```

It's up to schema build tool to resolve such references at load time.

## Common functionality

Most of the entities support the same functionality that should be 
described separately. Those entities are mapping types, tokenizers,
filters, analyzers, index settings and configuration options.

### Globs

In names can be set as glob patterns. This allows to validate options 
like `indices.analysis.hunspell.dictionary.*.ignore_case` or 
`routing.allocation.include.*`.

### Deprecated field

```yaml
deprecated: true
```

Such field would just tell that specified entity is deprecated, so
warning may be generated if someone uses it.

This works for parameters as well as other entities.

### Removed field

```yaml
removed: true
```

Such field is used to remove previously available entity from schema.

### Inheritance

```yaml
extends: <name>
```

Such field may be used to copy and overwrite state from entity sibling.
Currently only sibling relationships are supported, but this may change
in future. 

This works for parameters as well as other entities.

### Templates

Templates are entities with the very same structure but that are
removed on schema compilation, serving only as source for other 
entities.

```yaml
template: true
```

To use such a template, entity may use inheritance specified above, or,
if it has to just copy all template state, it may simply be listed in
`children`:

```yaml
template: true
type: boolean
default: true
children:
  - index
  - enabled
  - dynamic
```

This example would automatically generate three siblings to specified
template.

### Metadata

All entities support metadata field for extra data:

```yaml
metadata:
  x-nullable: true
```

### Title, summary and description

All entities may have `title`, `summary` and `description` fields with
arbitrary text.

## Parameters

Parameters are literally parameters that are found across mapping 
types, tokenizers, filters, etc. They are often reused, so they are 
usually specified above their place of use.

`ParameterMap` is just a map of parameters:

```yaml
<ParameterName>: <Parameter>
```
Concrete parameter is just a set of options:

- `type`, which tells that parameter value has specific type. There may
be several types specified as array.
- `default` providing default value
is not usable in current version
- `enum`, which tells that parameter may be not only of %type%, but 
also an array of %type%
- `values`, which lists possible parameter values
- `constraints` - list of validation constraints for parameter value
- `nullable` - whether value could be null or not

There is no need to specify extra options, they are just treated as 
defaults:

```yaml
dynamic:
  type: [string, boolean]
  default: true
  values:
    - true
    - false
    - 'true'
    - 'false'
    - strict
null_value:
  nullable: true
```

## Mapping

Mapping section simply describes mapping types:

```yaml
root:
  parameters:
    enabled: ~
    dynamic: ~
    properties: ~
```

## Index configuration

### Analysis

Analysis section consists of analyzers, tokenizers, token filters and 
character filters. All of them share the same schema with common 
options specified above and `parameters` option:

```yaml
index:
  analysis:
    analyzers:
      types:
        standard: ~
        stop:
          parameters:
            stopwords: ~
            stopwords_path: ~
    tokenizers:
      types: ...
```

### Settings

Settings are very similar to parameters, but also have `static` option
set to `false` by default:

```yaml
index:
  settings:
    number_of_replicas:
      type: integer
      constraints:
        - type: integer
          minimum: 0
    number_of_shards:
      type: integer
      static: true
      constraints:
        - type: integer
          minimum: 0
```

## ElasticSearch configuration

Configuration parameters share their schema with all other parameters:

```yaml
configuration:
  indices.analysis.hunspell.dictionary.ignore_case:
    type: boolean
    default: false
  indices.analysis.hunspell.dictionary.*.ignore_case:
    type: boolean
    default: false
```
