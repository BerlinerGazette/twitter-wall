name "php"
description "Role for installing php."

default_attributes({
})

override_attributes({
})

run_list(
  "recipe[php]",
  "recipe[php::module_sqlite3]"
)
