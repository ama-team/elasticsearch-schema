---
title: Constraints
---


Schema defines several places for validation constraints that may be
used to analyze user input. List of such constraints is not limited,
while this schema uses a finite set of constraints, custom schema
extensions may add their own constraints, so schema peers should not
break on unknown constraints. It is also considered to be good form to
prefix custom constraint names to prevent name clashing.

Following are the constraints used throughout default schema: 

## notNull

Validates that target is not null

```yaml
type: notNull
```

## boolean

Validates that target is a boolean value

```yaml
type: boolean
```

## string

Validates that target is a string

```yaml
type: string
minimumLength: 10
maximumLength: 12
```

## number

Validates that target is numeric (any integer or real number)

```yaml
type: number
minimum: 0
maximum: 10.5
exclusiveMaximum: true
exclusiveMinimum: false
```

## integer

Validates that target is an integer. Size (short, int, long, etc) is
not taken into account.

```yaml
type: integer
minimum: 0
maximum: 10
exclusiveMaximum: true
exclusiveMinimum: false
```

## real

Validates that target is a floating-point arithmetic number. Integer
numbers must pass this validation if implementation language coerces
numbers like 1.0 to 1. The precision (float, double, etc.) is not taken
into account.

```yaml
type: real
minimum: 0.5
maximum: 10.5
exclusiveMaximum: true
exclusiveMinimum: false
```

## array

Validates that target is a list

```yaml
type: array
```

## object

Validates that target is a key-value map / hash

```yaml
type: object
```

## amount

Special ElasticSearch constraint for validating values like `10`, `2k`,
`10m`

```yaml
type: amount
```

## time

Special ElasticSearch constraint for validating values like `10s`, 
`2m`, `10h`

```yaml
type: time
```

## anyOf

Validates that at least one of specified constraints is satisfied by
target

```yaml
type: anyOf
constraints:
  - type: string
  - type: boolean
```

## values

Applies specified constraints to all array/object values

```yaml
type: values
constraints:
  - type: string
  - type: notNull
```

## nested

Contains specific constraints for object properties

```yaml
type: nested
properties:
  aspects:
    - type: object
    - type: values
      constraints:
        - type: string
  mapping:
    - type: mappingType
```

## size

Validates target size

```yaml
type: size
maximum: 12
minimum: 11
```

## mappingType

Ensures that target specifies a valid mapping type. Constraint 
validator should refer to current schema to validate such value.

```yaml
type: mappingType
```

## glob

Ensures that target matches specified glob pattern:

```yaml
type: glob
pattern: '*=>*'
```

## Implicit constraints

Beside explicit constraints, there are three types of implicit 
constraints. First, if the entity hasn't been marked as 
`nullable: true`, a `nonNull` constraint should be added:

```yaml
type: string
```

Should be treated as 

```yaml
type: string
constraints:
  - type: nonNull
```
 
Second, every specified type should be treated like constraint of 
same name:

```yaml
type: string
nullable: true
``` 

implies:

```yaml
constraints:
  - type: string
```

If there is list of types specified, value should match any of those.

Finally, there is a case with predefined set of values:

```yaml
type: string
values:
  - alpha
  - beta
  - gamma
```

Which should be treated as something like

```yaml
constraints:
  - type: anyValue
    configuration:
      values:
        - alpha
        - beta
        - gamma
```

## Enum validation

Validator service should be aware of enums. Such values may be wrapped
in array, so validator should apply all constraints either to root or
every element.
