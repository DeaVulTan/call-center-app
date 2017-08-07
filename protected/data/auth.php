<?php
return array (
  'guest' => 
  array (
    'type' => 2,
    'description' => 'Гость',
    'bizRule' => NULL,
    'data' => NULL,
    'assignments' => 
    array (
      39 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'operator' => 
  array (
    'type' => 2,
    'description' => 'Оператор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'viewOperatorPanel',
    ),
    'assignments' => 
    array (
      39 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      6 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      41 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      40 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      42 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'seniorop' => 
  array (
    'type' => 2,
    'description' => 'Senior Operator',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'operator',
      2 => 'viewNotes',
      3 => 'canAdminNotes',
      4 => 'manageSwitchings',
      5 => 'manageReports',
    ),
    'assignments' => 
    array (
      38 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'supervisor' => 
  array (
    'type' => 2,
    'description' => 'Супервайзер',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'seniorop',
      1 => 'manageUsers',
      2 => 'manageSwitchings',
      3 => 'manageVIP',
      4 => 'viewAllServicesCalls',
      5 => 'canAdminNotes',
      6 => 'managerUserSip',
      7 => 'manageReports',
      8 => 'manageServices',
    ),
    'assignments' => 
    array (
      30 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      22 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => 'Администратор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'supervisor',
      1 => 'manageTE',
      2 => 'viewAllOnlineUsers',
      3 => 'canEditSetting',
      4 => 'adminServices',
    ),
    'assignments' => 
    array (
      22 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      26 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'viewOperatorPanel' => 
  array (
    'type' => 0,
    'description' => 'Are user can view operator panel',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewNotes' => 
  array (
    'type' => 0,
    'description' => 'Are user can view notes',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageUsers' => 
  array (
    'type' => 0,
    'description' => 'Are user can manage users',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageServices' => 
  array (
    'type' => 0,
    'description' => 'Are user can manage services',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageSwitchings' => 
  array (
    'type' => 0,
    'description' => 'Are user can manage switchings',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageVIP' => 
  array (
    'type' => 0,
    'description' => 'Are user can manage VIP',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageTE' => 
  array (
    'type' => 0,
    'description' => 'Are user can manate telephone exchage',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewAllServicesCalls' => 
  array (
    'type' => 0,
    'description' => 'Allows to view all calls by services in my queue widget',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewAllOnlineUsers' => 
  array (
    'type' => 0,
    'description' => 'Are user can view all online users',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageReports' => 
  array (
    'type' => 0,
    'description' => 'Can manage report',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'managerUserSip' => 
  array (
    'type' => 0,
    'description' => 'Can manage sip in user menu',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'canAdminNotes' => 
  array (
    'type' => 0,
    'description' => 'can admin notes and notefields',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'canEditSetting' => 
  array (
    'type' => 0,
    'description' => 'Can edit system settings',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'adminServices' => 
  array (
    'type' => 0,
    'description' => 'Can administrate services',
    'bizRule' => NULL,
    'data' => NULL,
  ),
);
