--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `blacklist_id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `ttl` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `whitelist`
--

CREATE TABLE `whitelist` (
  `whitelist_id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`blacklist_id`);

--
-- Indexes for table `whitelist`
--
ALTER TABLE `whitelist`
  ADD PRIMARY KEY (`whitelist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `blacklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `whitelist_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
