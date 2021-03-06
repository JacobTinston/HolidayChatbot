# Change Log
All notable changes to this project will be documented in this file.

## v3.0 2022-06-15
 
### Added
- Generates conversation ID that is used to identify conversation
- Stores a copy of the conversation as a flat file in storage directory with the name as the conversation ID.
- Created User Guide
 
### Changed
- Broaden accepted criteria by checking for keywords in full sentences.
 
### Fixed
- Downgraded to use PHP 7.4 - because the server runs on 7.4, not 8.0.10.

## v2.0 2022-06-14
 
### Added
- More questions
- Input sanitising
- Verifies user input against question keywords
- Temporarily save the conversation in order to gather/show results from holiday-data
 
### Changed
- Updated UI/UX
 
### Fixed

## v1.0 2022-06-13
 
### Added
- Set up boilerplate site
- Set up Laravel/Vue.js views - linked frontend/backend to show views correctly
- Added basic functionality to gather and store the name on the first user input.
 
### Changed
 
### Fixed
