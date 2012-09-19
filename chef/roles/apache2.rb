name "apache2"
description "Role for installing apache2."

default_attributes({
})

override_attributes({
})

run_list(
  "recipe[apache2]",
  "recipe[apache2::mod_rewrite]",
  "recipe[apache2::mod_php5]",
  "recipe[twitter-wall::apache2]"
)
