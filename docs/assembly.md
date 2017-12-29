---
title: Schema assembly algorithm
---

First, let's define some terms:

- **Source** is a resource containing map of **product schemes**. 
Source can be virtually anything providing such a map, but usually that's 
just a YAML/JSON file.
- **Product scheme** is an object which may contain arbitrary amount of 
**versions** of particular software. Such software can be ElasticSearch
itself or one of it's plugins.
- Every **version** is just a schema defining which parameters, types 
and other entities are available in particular version of software.
- **Tool** would be used further as an abstract thing implementing the
algorithm.

At some point of time end user provides tool with sources and requests 
tool for a schema for particular set of software versions. The tool 
then does the following:

- Loads all sources as plain objects, resolving any JSON pointers
contained in schemas. 
- Checks every source against validation schema
- Merges all overlapping versions in sources: if source A contains 
ElasticSearch/6.0.0 and source B also contains ElasticSearch/6.0.0,
definitions for those versions are merged into one object. Reaction
to overlapping entities (e.g. if both versions contain different 
definitions for same mapping type) is up to implementation: it may be
silent overwrite, logged warnings or raised error.
- On next stage tool resolves particular versions of software: fills
- After that 

## Resolution phase

On the first step user provides algorithm with one or more data 
sources. Each source should provide a product schema map (see 
[meta-schema](meta-schema)), optionally split into several resources
using JSON pointers, and on this phase assembly tool should read all 
provided sources and resolve all containing JSON pointers, raising an
error if any source is unreadable/unresolvable. The result of this
phase is just a collection of structures - one for each source.

## Validation phase

This phase simply validates obtained structures to ensure that every 
source is a map of product schemas. It's implied that assembly tool 
should raise an error in case of invalid schema.

## Product-version merge phase

In case read structures contain one product version several times, tool
should merge all those definitions into one version. It is up to 
processing tool to choose a strategy for resolving (or not resolving)
possible conflicts, it may either silently overwrite overlapping 
values, show warnings or raise errors. It is recommended to provide end
user configuration option to control such strategy.

## Normalization phase

This phase is used to build complete schemas for each software version.
Version processing consists of just two steps:

- Finding and building all inherited entities
- Resolving (merging) entity parameters (see parameter resolution 
procedure below)

After that each version is actually a difference from previous one.

## Merge phase

During this phase processor builds schema for target products and 
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
