maintainer       "foobugs Oelke & Eichner GbR"
maintainer_email "rene.oelke@foobugs.com"
license          "Apache 2.0"
description      "Installs and configures all aspects for TwitterWall development environment."
long_description IO.read(File.join(File.dirname(__FILE__), 'README.md'))
version          "1.0.0"

recipe            "twitter-wall", "Common installation and configuration"
recipe            "twitter-wall::apache2", "Installation and configuration for apache2"

%w{ ubuntu debian }.each do |os|
  supports os
end
