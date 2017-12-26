---
title: Schema assembly algorithm
---

## Resolution phase

On the first step user provides algorithm with one or more data 
sources. Those sources may contain different versions for different
products, and on this stage algorithm resolves those sources into 
in-memory structures - usually this will mean just reading files and
resolving `$ref` references. The result of this phase is jsut a 
collection of structures (one for every source) that may contain 
invalid data.

## Validation phase

This phase simply validates obtained structures to ensure they are
valid instances of ElasticSearch schema.

## Normalization phase

This phase is intended to dispose any necessity of processing in 
schema. It walks through all entities, finds templates and inherited
entities, then creates template derivatives / fills inherited entities
and removes all templates, after that it resolves all parameters (see
parameter resolution procedure below) for every entity in schema. The 
result of such operation is a schema without parameter maps - all 
required parameters have to be contained within entities themselves.

## Merge phase

During this phase proccessor builds schema for target products and 
version. For each product it calculates target state, after which it
is merged with products current one inherits. After all products 
schemas have been finished, they are merged together. Schema builder
should raise errors for any conflicts between different products on 
this phase.

## Parameter resolution procedure

Parameter resolution procedure is too simple but should be highlighted
as well. Whenever entity X requests parameter Y, resolver walks up
the tree from that entity, trying to find Y in `parameters` element on
every level. After hierarchy has been completed, it creates new blank
parameter, overwrites it with properties from every parameter in
hierarchy (starting from the "ground"), and returns the result.
