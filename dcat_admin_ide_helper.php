<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection check_id
     * @property Grid\Column|Collection desc
     * @property Grid\Column|Collection images
     * @property Grid\Column|Collection is_check
     * @property Grid\Column|Collection is_problem
     * @property Grid\Column|Collection is_push
     * @property Grid\Column|Collection line_id
     * @property Grid\Column|Collection region_id
     * @property Grid\Column|Collection videos
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection date
     * @property Grid\Column|Collection duty_name
     * @property Grid\Column|Collection inspect_data_id
     * @property Grid\Column|Collection user_name
     * @property Grid\Column|Collection water
     * @property Grid\Column|Collection weather
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection compiled_at
     * @property Grid\Column|Collection file
     * @property Grid\Column|Collection project_id
     * @property Grid\Column|Collection project_type
     * @property Grid\Column|Collection unit
     * @property Grid\Column|Collection admin_id
     * @property Grid\Column|Collection is_dispose
     * @property Grid\Column|Collection lat
     * @property Grid\Column|Collection lon
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection report_person
     * @property Grid\Column|Collection Inflation_bag
     * @property Grid\Column|Collection sacks
     * @property Grid\Column|Collection straw_bag
     * @property Grid\Column|Collection warehouse
     * @property Grid\Column|Collection woven_bag
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection mj1
     * @property Grid\Column|Collection mj2
     * @property Grid\Column|Collection mj3
     * @property Grid\Column|Collection mj4
     * @property Grid\Column|Collection mj5
     * @property Grid\Column|Collection quo
     * @property Grid\Column|Collection villagers
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection device_info
     * @property Grid\Column|Collection report_status
     * @property Grid\Column|Collection time
     * @property Grid\Column|Collection water_level
     * @property Grid\Column|Collection end_clock_id
     * @property Grid\Column|Collection inspect_table
     * @property Grid\Column|Collection macid
     * @property Grid\Column|Collection start_clock_id
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection client_id
     * @property Grid\Column|Collection clock_date
     * @property Grid\Column|Collection actual_completed_money
     * @property Grid\Column|Collection declaration_file
     * @property Grid\Column|Collection declaration_money
     * @property Grid\Column|Collection payed_money
     * @property Grid\Column|Collection plan_file
     * @property Grid\Column|Collection self_raised_money
     * @property Grid\Column|Collection top_money
     * @property Grid\Column|Collection year
     * @property Grid\Column|Collection after_image
     * @property Grid\Column|Collection before_image
     * @property Grid\Column|Collection begin_at
     * @property Grid\Column|Collection completed_at
     * @property Grid\Column|Collection end_at
     * @property Grid\Column|Collection is_complete
     * @property Grid\Column|Collection code
     * @property Grid\Column|Collection complete_image
     * @property Grid\Column|Collection defect_content
     * @property Grid\Column|Collection found_at
     * @property Grid\Column|Collection found_people
     * @property Grid\Column|Collection found_type
     * @property Grid\Column|Collection image
     * @property Grid\Column|Collection is_push_result
     * @property Grid\Column|Collection is_push_yh
     * @property Grid\Column|Collection is_send
     * @property Grid\Column|Collection note
     * @property Grid\Column|Collection opinion
     * @property Grid\Column|Collection plan_completed_at
     * @property Grid\Column|Collection process_mode
     * @property Grid\Column|Collection process_state
     * @property Grid\Column|Collection recipient
     * @property Grid\Column|Collection rid_people
     * @property Grid\Column|Collection rid_phone
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection project_name
     * @property Grid\Column|Collection competent_department
     * @property Grid\Column|Collection competent_department_job
     * @property Grid\Column|Collection competent_department_name
     * @property Grid\Column|Collection competent_department_phone
     * @property Grid\Column|Collection competent_department_unit
     * @property Grid\Column|Collection government_branch_job
     * @property Grid\Column|Collection government_branch_name
     * @property Grid\Column|Collection government_job
     * @property Grid\Column|Collection government_name
     * @property Grid\Column|Collection inspector_name
     * @property Grid\Column|Collection inspector_phone
     * @property Grid\Column|Collection management_address
     * @property Grid\Column|Collection management_head
     * @property Grid\Column|Collection management_name
     * @property Grid\Column|Collection management_nature
     * @property Grid\Column|Collection management_phone
     * @property Grid\Column|Collection management_worker_num
     * @property Grid\Column|Collection management_worker_on_guard_num
     * @property Grid\Column|Collection management_zip_code
     * @property Grid\Column|Collection water_administration_department
     * @property Grid\Column|Collection job
     * @property Grid\Column|Collection default
     * @property Grid\Column|Collection mds
     * @property Grid\Column|Collection edu
     * @property Grid\Column|Collection fishing_name
     * @property Grid\Column|Collection job_title
     * @property Grid\Column|Collection professional
     * @property Grid\Column|Collection principal
     *
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection check_id(string $label = null)
     * @method Grid\Column|Collection desc(string $label = null)
     * @method Grid\Column|Collection images(string $label = null)
     * @method Grid\Column|Collection is_check(string $label = null)
     * @method Grid\Column|Collection is_problem(string $label = null)
     * @method Grid\Column|Collection is_push(string $label = null)
     * @method Grid\Column|Collection line_id(string $label = null)
     * @method Grid\Column|Collection region_id(string $label = null)
     * @method Grid\Column|Collection videos(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection date(string $label = null)
     * @method Grid\Column|Collection duty_name(string $label = null)
     * @method Grid\Column|Collection inspect_data_id(string $label = null)
     * @method Grid\Column|Collection user_name(string $label = null)
     * @method Grid\Column|Collection water(string $label = null)
     * @method Grid\Column|Collection weather(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection compiled_at(string $label = null)
     * @method Grid\Column|Collection file(string $label = null)
     * @method Grid\Column|Collection project_id(string $label = null)
     * @method Grid\Column|Collection project_type(string $label = null)
     * @method Grid\Column|Collection unit(string $label = null)
     * @method Grid\Column|Collection admin_id(string $label = null)
     * @method Grid\Column|Collection is_dispose(string $label = null)
     * @method Grid\Column|Collection lat(string $label = null)
     * @method Grid\Column|Collection lon(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection report_person(string $label = null)
     * @method Grid\Column|Collection Inflation_bag(string $label = null)
     * @method Grid\Column|Collection sacks(string $label = null)
     * @method Grid\Column|Collection straw_bag(string $label = null)
     * @method Grid\Column|Collection warehouse(string $label = null)
     * @method Grid\Column|Collection woven_bag(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection mj1(string $label = null)
     * @method Grid\Column|Collection mj2(string $label = null)
     * @method Grid\Column|Collection mj3(string $label = null)
     * @method Grid\Column|Collection mj4(string $label = null)
     * @method Grid\Column|Collection mj5(string $label = null)
     * @method Grid\Column|Collection quo(string $label = null)
     * @method Grid\Column|Collection villagers(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection device_info(string $label = null)
     * @method Grid\Column|Collection report_status(string $label = null)
     * @method Grid\Column|Collection time(string $label = null)
     * @method Grid\Column|Collection water_level(string $label = null)
     * @method Grid\Column|Collection end_clock_id(string $label = null)
     * @method Grid\Column|Collection inspect_table(string $label = null)
     * @method Grid\Column|Collection macid(string $label = null)
     * @method Grid\Column|Collection start_clock_id(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection client_id(string $label = null)
     * @method Grid\Column|Collection clock_date(string $label = null)
     * @method Grid\Column|Collection actual_completed_money(string $label = null)
     * @method Grid\Column|Collection declaration_file(string $label = null)
     * @method Grid\Column|Collection declaration_money(string $label = null)
     * @method Grid\Column|Collection payed_money(string $label = null)
     * @method Grid\Column|Collection plan_file(string $label = null)
     * @method Grid\Column|Collection self_raised_money(string $label = null)
     * @method Grid\Column|Collection top_money(string $label = null)
     * @method Grid\Column|Collection year(string $label = null)
     * @method Grid\Column|Collection after_image(string $label = null)
     * @method Grid\Column|Collection before_image(string $label = null)
     * @method Grid\Column|Collection begin_at(string $label = null)
     * @method Grid\Column|Collection completed_at(string $label = null)
     * @method Grid\Column|Collection end_at(string $label = null)
     * @method Grid\Column|Collection is_complete(string $label = null)
     * @method Grid\Column|Collection code(string $label = null)
     * @method Grid\Column|Collection complete_image(string $label = null)
     * @method Grid\Column|Collection defect_content(string $label = null)
     * @method Grid\Column|Collection found_at(string $label = null)
     * @method Grid\Column|Collection found_people(string $label = null)
     * @method Grid\Column|Collection found_type(string $label = null)
     * @method Grid\Column|Collection image(string $label = null)
     * @method Grid\Column|Collection is_push_result(string $label = null)
     * @method Grid\Column|Collection is_push_yh(string $label = null)
     * @method Grid\Column|Collection is_send(string $label = null)
     * @method Grid\Column|Collection note(string $label = null)
     * @method Grid\Column|Collection opinion(string $label = null)
     * @method Grid\Column|Collection plan_completed_at(string $label = null)
     * @method Grid\Column|Collection process_mode(string $label = null)
     * @method Grid\Column|Collection process_state(string $label = null)
     * @method Grid\Column|Collection recipient(string $label = null)
     * @method Grid\Column|Collection rid_people(string $label = null)
     * @method Grid\Column|Collection rid_phone(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection project_name(string $label = null)
     * @method Grid\Column|Collection competent_department(string $label = null)
     * @method Grid\Column|Collection competent_department_job(string $label = null)
     * @method Grid\Column|Collection competent_department_name(string $label = null)
     * @method Grid\Column|Collection competent_department_phone(string $label = null)
     * @method Grid\Column|Collection competent_department_unit(string $label = null)
     * @method Grid\Column|Collection government_branch_job(string $label = null)
     * @method Grid\Column|Collection government_branch_name(string $label = null)
     * @method Grid\Column|Collection government_job(string $label = null)
     * @method Grid\Column|Collection government_name(string $label = null)
     * @method Grid\Column|Collection inspector_name(string $label = null)
     * @method Grid\Column|Collection inspector_phone(string $label = null)
     * @method Grid\Column|Collection management_address(string $label = null)
     * @method Grid\Column|Collection management_head(string $label = null)
     * @method Grid\Column|Collection management_name(string $label = null)
     * @method Grid\Column|Collection management_nature(string $label = null)
     * @method Grid\Column|Collection management_phone(string $label = null)
     * @method Grid\Column|Collection management_worker_num(string $label = null)
     * @method Grid\Column|Collection management_worker_on_guard_num(string $label = null)
     * @method Grid\Column|Collection management_zip_code(string $label = null)
     * @method Grid\Column|Collection water_administration_department(string $label = null)
     * @method Grid\Column|Collection job(string $label = null)
     * @method Grid\Column|Collection default(string $label = null)
     * @method Grid\Column|Collection mds(string $label = null)
     * @method Grid\Column|Collection edu(string $label = null)
     * @method Grid\Column|Collection fishing_name(string $label = null)
     * @method Grid\Column|Collection job_title(string $label = null)
     * @method Grid\Column|Collection professional(string $label = null)
     * @method Grid\Column|Collection principal(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection order
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection username
     * @property Show\Field|Collection check_id
     * @property Show\Field|Collection desc
     * @property Show\Field|Collection images
     * @property Show\Field|Collection is_check
     * @property Show\Field|Collection is_problem
     * @property Show\Field|Collection is_push
     * @property Show\Field|Collection line_id
     * @property Show\Field|Collection region_id
     * @property Show\Field|Collection videos
     * @property Show\Field|Collection content
     * @property Show\Field|Collection date
     * @property Show\Field|Collection duty_name
     * @property Show\Field|Collection inspect_data_id
     * @property Show\Field|Collection user_name
     * @property Show\Field|Collection water
     * @property Show\Field|Collection weather
     * @property Show\Field|Collection address
     * @property Show\Field|Collection compiled_at
     * @property Show\Field|Collection file
     * @property Show\Field|Collection project_id
     * @property Show\Field|Collection project_type
     * @property Show\Field|Collection unit
     * @property Show\Field|Collection admin_id
     * @property Show\Field|Collection is_dispose
     * @property Show\Field|Collection lat
     * @property Show\Field|Collection lon
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection report_person
     * @property Show\Field|Collection Inflation_bag
     * @property Show\Field|Collection sacks
     * @property Show\Field|Collection straw_bag
     * @property Show\Field|Collection warehouse
     * @property Show\Field|Collection woven_bag
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection mj1
     * @property Show\Field|Collection mj2
     * @property Show\Field|Collection mj3
     * @property Show\Field|Collection mj4
     * @property Show\Field|Collection mj5
     * @property Show\Field|Collection quo
     * @property Show\Field|Collection villagers
     * @property Show\Field|Collection path
     * @property Show\Field|Collection device_info
     * @property Show\Field|Collection report_status
     * @property Show\Field|Collection time
     * @property Show\Field|Collection water_level
     * @property Show\Field|Collection end_clock_id
     * @property Show\Field|Collection inspect_table
     * @property Show\Field|Collection macid
     * @property Show\Field|Collection start_clock_id
     * @property Show\Field|Collection status
     * @property Show\Field|Collection client_id
     * @property Show\Field|Collection clock_date
     * @property Show\Field|Collection actual_completed_money
     * @property Show\Field|Collection declaration_file
     * @property Show\Field|Collection declaration_money
     * @property Show\Field|Collection payed_money
     * @property Show\Field|Collection plan_file
     * @property Show\Field|Collection self_raised_money
     * @property Show\Field|Collection top_money
     * @property Show\Field|Collection year
     * @property Show\Field|Collection after_image
     * @property Show\Field|Collection before_image
     * @property Show\Field|Collection begin_at
     * @property Show\Field|Collection completed_at
     * @property Show\Field|Collection end_at
     * @property Show\Field|Collection is_complete
     * @property Show\Field|Collection code
     * @property Show\Field|Collection complete_image
     * @property Show\Field|Collection defect_content
     * @property Show\Field|Collection found_at
     * @property Show\Field|Collection found_people
     * @property Show\Field|Collection found_type
     * @property Show\Field|Collection image
     * @property Show\Field|Collection is_push_result
     * @property Show\Field|Collection is_push_yh
     * @property Show\Field|Collection is_send
     * @property Show\Field|Collection note
     * @property Show\Field|Collection opinion
     * @property Show\Field|Collection plan_completed_at
     * @property Show\Field|Collection process_mode
     * @property Show\Field|Collection process_state
     * @property Show\Field|Collection recipient
     * @property Show\Field|Collection rid_people
     * @property Show\Field|Collection rid_phone
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection project_name
     * @property Show\Field|Collection competent_department
     * @property Show\Field|Collection competent_department_job
     * @property Show\Field|Collection competent_department_name
     * @property Show\Field|Collection competent_department_phone
     * @property Show\Field|Collection competent_department_unit
     * @property Show\Field|Collection government_branch_job
     * @property Show\Field|Collection government_branch_name
     * @property Show\Field|Collection government_job
     * @property Show\Field|Collection government_name
     * @property Show\Field|Collection inspector_name
     * @property Show\Field|Collection inspector_phone
     * @property Show\Field|Collection management_address
     * @property Show\Field|Collection management_head
     * @property Show\Field|Collection management_name
     * @property Show\Field|Collection management_nature
     * @property Show\Field|Collection management_phone
     * @property Show\Field|Collection management_worker_num
     * @property Show\Field|Collection management_worker_on_guard_num
     * @property Show\Field|Collection management_zip_code
     * @property Show\Field|Collection water_administration_department
     * @property Show\Field|Collection job
     * @property Show\Field|Collection default
     * @property Show\Field|Collection mds
     * @property Show\Field|Collection edu
     * @property Show\Field|Collection fishing_name
     * @property Show\Field|Collection job_title
     * @property Show\Field|Collection professional
     * @property Show\Field|Collection principal
     *
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection check_id(string $label = null)
     * @method Show\Field|Collection desc(string $label = null)
     * @method Show\Field|Collection images(string $label = null)
     * @method Show\Field|Collection is_check(string $label = null)
     * @method Show\Field|Collection is_problem(string $label = null)
     * @method Show\Field|Collection is_push(string $label = null)
     * @method Show\Field|Collection line_id(string $label = null)
     * @method Show\Field|Collection region_id(string $label = null)
     * @method Show\Field|Collection videos(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection date(string $label = null)
     * @method Show\Field|Collection duty_name(string $label = null)
     * @method Show\Field|Collection inspect_data_id(string $label = null)
     * @method Show\Field|Collection user_name(string $label = null)
     * @method Show\Field|Collection water(string $label = null)
     * @method Show\Field|Collection weather(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection compiled_at(string $label = null)
     * @method Show\Field|Collection file(string $label = null)
     * @method Show\Field|Collection project_id(string $label = null)
     * @method Show\Field|Collection project_type(string $label = null)
     * @method Show\Field|Collection unit(string $label = null)
     * @method Show\Field|Collection admin_id(string $label = null)
     * @method Show\Field|Collection is_dispose(string $label = null)
     * @method Show\Field|Collection lat(string $label = null)
     * @method Show\Field|Collection lon(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection report_person(string $label = null)
     * @method Show\Field|Collection Inflation_bag(string $label = null)
     * @method Show\Field|Collection sacks(string $label = null)
     * @method Show\Field|Collection straw_bag(string $label = null)
     * @method Show\Field|Collection warehouse(string $label = null)
     * @method Show\Field|Collection woven_bag(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection mj1(string $label = null)
     * @method Show\Field|Collection mj2(string $label = null)
     * @method Show\Field|Collection mj3(string $label = null)
     * @method Show\Field|Collection mj4(string $label = null)
     * @method Show\Field|Collection mj5(string $label = null)
     * @method Show\Field|Collection quo(string $label = null)
     * @method Show\Field|Collection villagers(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection device_info(string $label = null)
     * @method Show\Field|Collection report_status(string $label = null)
     * @method Show\Field|Collection time(string $label = null)
     * @method Show\Field|Collection water_level(string $label = null)
     * @method Show\Field|Collection end_clock_id(string $label = null)
     * @method Show\Field|Collection inspect_table(string $label = null)
     * @method Show\Field|Collection macid(string $label = null)
     * @method Show\Field|Collection start_clock_id(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection client_id(string $label = null)
     * @method Show\Field|Collection clock_date(string $label = null)
     * @method Show\Field|Collection actual_completed_money(string $label = null)
     * @method Show\Field|Collection declaration_file(string $label = null)
     * @method Show\Field|Collection declaration_money(string $label = null)
     * @method Show\Field|Collection payed_money(string $label = null)
     * @method Show\Field|Collection plan_file(string $label = null)
     * @method Show\Field|Collection self_raised_money(string $label = null)
     * @method Show\Field|Collection top_money(string $label = null)
     * @method Show\Field|Collection year(string $label = null)
     * @method Show\Field|Collection after_image(string $label = null)
     * @method Show\Field|Collection before_image(string $label = null)
     * @method Show\Field|Collection begin_at(string $label = null)
     * @method Show\Field|Collection completed_at(string $label = null)
     * @method Show\Field|Collection end_at(string $label = null)
     * @method Show\Field|Collection is_complete(string $label = null)
     * @method Show\Field|Collection code(string $label = null)
     * @method Show\Field|Collection complete_image(string $label = null)
     * @method Show\Field|Collection defect_content(string $label = null)
     * @method Show\Field|Collection found_at(string $label = null)
     * @method Show\Field|Collection found_people(string $label = null)
     * @method Show\Field|Collection found_type(string $label = null)
     * @method Show\Field|Collection image(string $label = null)
     * @method Show\Field|Collection is_push_result(string $label = null)
     * @method Show\Field|Collection is_push_yh(string $label = null)
     * @method Show\Field|Collection is_send(string $label = null)
     * @method Show\Field|Collection note(string $label = null)
     * @method Show\Field|Collection opinion(string $label = null)
     * @method Show\Field|Collection plan_completed_at(string $label = null)
     * @method Show\Field|Collection process_mode(string $label = null)
     * @method Show\Field|Collection process_state(string $label = null)
     * @method Show\Field|Collection recipient(string $label = null)
     * @method Show\Field|Collection rid_people(string $label = null)
     * @method Show\Field|Collection rid_phone(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection project_name(string $label = null)
     * @method Show\Field|Collection competent_department(string $label = null)
     * @method Show\Field|Collection competent_department_job(string $label = null)
     * @method Show\Field|Collection competent_department_name(string $label = null)
     * @method Show\Field|Collection competent_department_phone(string $label = null)
     * @method Show\Field|Collection competent_department_unit(string $label = null)
     * @method Show\Field|Collection government_branch_job(string $label = null)
     * @method Show\Field|Collection government_branch_name(string $label = null)
     * @method Show\Field|Collection government_job(string $label = null)
     * @method Show\Field|Collection government_name(string $label = null)
     * @method Show\Field|Collection inspector_name(string $label = null)
     * @method Show\Field|Collection inspector_phone(string $label = null)
     * @method Show\Field|Collection management_address(string $label = null)
     * @method Show\Field|Collection management_head(string $label = null)
     * @method Show\Field|Collection management_name(string $label = null)
     * @method Show\Field|Collection management_nature(string $label = null)
     * @method Show\Field|Collection management_phone(string $label = null)
     * @method Show\Field|Collection management_worker_num(string $label = null)
     * @method Show\Field|Collection management_worker_on_guard_num(string $label = null)
     * @method Show\Field|Collection management_zip_code(string $label = null)
     * @method Show\Field|Collection water_administration_department(string $label = null)
     * @method Show\Field|Collection job(string $label = null)
     * @method Show\Field|Collection default(string $label = null)
     * @method Show\Field|Collection mds(string $label = null)
     * @method Show\Field|Collection edu(string $label = null)
     * @method Show\Field|Collection fishing_name(string $label = null)
     * @method Show\Field|Collection job_title(string $label = null)
     * @method Show\Field|Collection professional(string $label = null)
     * @method Show\Field|Collection principal(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
