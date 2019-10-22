create SCHEMA `yeti`;
create TABLE roley (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name CHAR(128)
);

create TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name CHAR(128)
);

create TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name CHAR(128) NOT NULL,
                       email CHAR(128) NOT NULL,
                       password CHAR(128) NOT NULL,
                       contacts CHAR(128),
                       add_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       roley_id INT NOT NULL,
                       FOREIGN KEY (roley_id) REFERENCES roley (id)
);

create TABLE lots (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      name CHAR(128) NOT NULL,
                      description CHAR(128) NOT NULL,
                      url CHAR(128) NOT NULL, --url/img
                      cost INT NOT NULL, --cost/start_cost
                      add_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      date CHAR(128) NOT NULL, --date/lost_date
                      step_cost INT,
                      user_id INT NOT NULL,
                      categories_id INT NOT NULL,
                      FOREIGN KEY (user_id) REFERENCES users (id),
                      FOREIGN KEY (categories_id) REFERENCES categories (id)
);


create TABLE rate (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      raise_cost INT NOT NULL,
                      add_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      user_id INT NOT NULL,
                      lots_id INT NOT NULL,
                      FOREIGN KEY (user_id) REFERENCES users (id),
                      FOREIGN KEY (lots_id) REFERENCES lots (id)
);

create unique index email on users(email);
create unique index names on users(name);
create index name on lots(name);
create index description on lots(description);
create index cost on lots(cost);
create index date on lots(date);
create index raise_cost on rate(raise_cost);
create index add_date on rate(add_date);