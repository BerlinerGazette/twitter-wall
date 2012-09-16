name "twitter-wall"
description "Role for installing a TwitterWall development."

default_attributes({
})

override_attributes({
})

run_list(
  "recipe[apt]",
  "recipe[twitter-wall]",
  "role[sqlite]",
  "role[php]",
  "role[apache2]"
)
