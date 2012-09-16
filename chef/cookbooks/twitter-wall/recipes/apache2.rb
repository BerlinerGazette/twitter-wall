#
# Cookbook Name:: twitter-wall
# Recipe:: apache2
#
# Copyright 2008-2011, Opscode, Inc.
# Copyright 2012, foobugs Oelke & Eichner GbR
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#

# Configure default site
template "#{node['apache']['dir']}/sites-available/default" do
  source "default-site.erb"
  owner "root"
  group node['apache']['root_group']
  mode 0644
  notifies :restart, resources(:service => "apache2")
end

# Set ownerships and permissions for web root
bash "Set ownerships and permissions for web root" do
  code <<-EOH
    chgrp -R www-data /vagrant
    find /vagrant -type d -exec chmod -R g+ws {} \\;
  EOH
end
