name "sqlite"
description "Role for installing sqlite."

default_attributes({
})

override_attributes({
})

run_list(
  "recipe[sqlite]"
)
