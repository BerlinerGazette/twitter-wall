name "apt"
description "Role for installing apt."

default_attributes({
})

override_attributes({
})

run_list(
  "recipe[apt]"
)
