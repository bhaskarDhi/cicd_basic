variable "region" {
  description = "AWS region (Mumbai)"
  type        = string
  default     = "ap-south-1"
}

variable "instance_type" {
  description = "EC2 size"
  type        = string
  default     = "t3.micro"
}

variable "my_ip" {
  description = "Your public IP with /32, allowed to SSH. Example: 103.10.20.30/32"
  type        = string
}

variable "public_key_path" {
  description = "Your SSH public key on the Mac"
  type        = string
  default     = "~/.ssh/id_ed25519.pub"
}
